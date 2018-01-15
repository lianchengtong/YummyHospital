<?php

namespace application\controllers;

use application\base\WebController;
use common\models\AuthWechat;
use common\models\MemberCardPayLog;
use common\models\MemberOwnCard;
use common\models\Order;
use common\models\OrderMontData;
use common\models\PromotionCard;
use common\models\UserCoin;
use common\utils\Json;
use common\utils\pay\Wechat;
use common\utils\Request;
use common\utils\UserSession;
use yii\web\NotFoundHttpException;

class PayController extends WebController
{
    public function actionIndex()
    {
        $orderModel = $this->getOrderModel();
        $montData = $orderModel->montData;

        $montDataList = [];
        /** @var OrderMontData $item */
        foreach ($montData as $item) {
            if (in_array($item->name, ['callback', 'minus'])) {
                $item->content = json_decode($item->content, true);
            }
            $montDataList[$item->name] = $item->content;
        }

        $enableCoin = true;
        if (isset($montDataList['enableCoin']) && $montDataList['enableCoin'] == 0) {
            $enableCoin = false;
        }

        $enableCode = true;
        if (isset($montDataList['enableCode']) && $montDataList['enableCode'] == 0) {
            $enableCode = false;
        }

        $enableCard = true;
        if (isset($montDataList['enableCard']) && $montDataList['enableCard'] == 0) {
            $enableCard = false;
        }

        return $this->setViewData([
            'title'   => '订单支付',
            'showTab' => 'false',
        ])->output("page.order-checkout", [
            'model'      => $orderModel,
            'enableCoin' => $enableCoin,
            'enableCode' => $enableCode,
            'enableCard' => $enableCard,
        ]);
    }

    public function actionCheckout()
    {
        $orderModel = $this->getOrderModel();

        $data = Request::input("data");
        $code = $data['code'];
        $coin = $data['coin'] == 1;
        $channel = $data['channel'];

        $trans = \Yii::$app->getDb()->beginTransaction();
        try {
            $sysChannelList = Order::getPayChannel();
            if (!isset($sysChannelList)) {
                throw new \Exception("channel not exist");
            }

            $payPrice = $orderModel->getPriceYuan();
            $minusMoney = [
                'coin' => 0,
                'code' => 0,
                'card' => 0,
            ];
            if ($coin) {
                $userCoin = \common\utils\UserSession::getCoin();
                $coinRate = \common\models\WebsiteConfig::getValueByKey("global.coin-rate");
                $minusMoney['coin'] = $userCoin * $coinRate;

                if (true !== UserCoin::cost(UserSession::getId(), $userCoin, "订单消费抵扣")) {
                    throw new \Exception("desc coin fail");
                }
            }

            if (strlen($code)) {
                $promotionCard = PromotionCard::getByCardNumber($code);
                if (!$promotionCard || $promotionCard->active_at > 0) {
                    throw new \Exception("invalid card");
                }
                $minusMoney['code'] = $promotionCard->card_worth;

                $result = PromotionCard::activeForUser($code, UserSession::getId());
                if (true !== $result) {
                    throw new \Exception("active promotion card fail!");
                }
            }

            $payPrice -= array_sum($minusMoney);
            if ($channel == Order::CHANNEL_CARD) {
                $userCard = MemberOwnCard::getUserEnableCard(UserSession::getId());
                if (!$userCard) {
                    throw new \Exception("no valid user card find");
                }
                $minusMoney['card'] = $orderModel->getPriceYuan() * (1 - ($userCard->discount / 100));

                if ($userCard->remain_money < $payPrice) {
                    $this->addError("会员卡余额不足，请充值或选择其它支付通道!");
                    throw new \Exception("user card remain money not enough");
                }

                $payPrice -= $minusMoney['card'];
                $result = MemberCardPayLog::add($userCard->id, $orderModel->id, $orderModel->getPriceYuan(), $payPrice);
                if (true !== $result) {
                    throw new \Exception("member card pay log exception");
                }
                $userCard->remain_money -= $payPrice;
                if (true !== $userCard->saveOrError()) {
                    throw new \Exception("desc user card money fail");
                }

                $result = $orderModel->completeWithTradeNumber("card-pay", Order::CHANNEL_CARD);
                if (true !== $result) {
                    throw new \Exception("update order status fail");
                }

                $montData = OrderMontData::addData($orderModel->id, "minus", json_encode($minusMoney));
                if (true !== $montData) {
                    throw new \Exception("add mont data fail");
                }

                $trans->commit();

                return Json::success();
            }

            $montData = OrderMontData::addData($orderModel->id, "minus", json_encode($minusMoney));
            if (true !== $montData) {
                throw new \Exception("add mont data fail");
            }

            if ($channel == Order::CHANNEL_WECHATPAY) {
                $openID = (new AuthWechat())->getByUserID(UserSession::getId())->getOpenID();
                $response = Wechat::createJSOrder($openID, $orderModel->name, $orderModel->order_id, $payPrice * 100);
                if ($response === false) {
                    return Json::error("非法请求");
                }

                return Json::success($response);
            }

            if ($channel == Order::CHANNEL_ALIPAY) {
                return Json::error("not support");
            }

            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollBack();

            return Json::error("系统错误: " . $e->getMessage());
        }
    }

    public function actionSuccess()
    {
//        $orderModel = $this->getOrderModel();
//        if (!$orderModel || !$orderModel->getIsPaySuccess()) {
//            throw new NotFoundHttpException();
//        }
        return $this->setViewData([
            'showNav' => false,
        ])->output("page.pay-success");
    }

    public function actionCodeInfo()
    {
        $codeID = Request::input("code");
        $model = PromotionCard::getByCardNumber($codeID);
        if (!$model) {
            return Json::error("卡号不存在");
        }

        return Json::success($model->card_worth);
    }


    private function getOrderModel()
    {
        $orderID = Request::input("id");
        $orderModel = Order::getByOrderID($orderID);
        if (!$orderModel) {
            throw new NotFoundHttpException();
        }

        if ($orderModel->status != Order::STATUS_PENDING_PAY) {
            throw new NotFoundHttpException();
        }

        return $orderModel;
    }
}
