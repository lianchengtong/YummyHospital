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
        if (Request::isPost()) {
            $data    = Request::input("data");
            $code    = $data['code'];
            $coin    = $data['coin'] == 1;
            $channel = $data['channel'];

            $trans = \Yii::$app->getDb()->beginTransaction();
            try {
                $sysChannelList = Order::getPayChannel();
                if (!isset($sysChannelList)) {
                    throw new \Exception("channel not exist");
                }

                $payPrice   = $orderModel->getPriceYuan();
                $minusMoney = [
                    'coin' => 0,
                    'code' => 0,
                    'card' => 0,
                ];
                if ($coin) {
                    $userCoin           = \common\utils\UserSession::getCoin();
                    $coinRate           = \common\models\WebsiteConfig::getValueByKey("global.coin-rate");
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

                    $payPrice -= array_sum($minusMoney);
                    $result   = MemberCardPayLog::add($userCard->id, $orderModel->id, $orderModel->getPriceYuan(), $payPrice);
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

                    return $this->redirect(['success']);
                }

                $trans->commit();
            } catch (\Exception $e) {
                $trans->rollBack();
                $this->addError("系统错误");
            }
        }

        return $this->render("index", [
            'model' => $orderModel,
        ]);
    }

    public function actionSuccess()
    {
        return "SUCCESS";
    }

    private function getOrderModel()
    {
        $orderID    = Request::input("id");
        $orderModel = Order::getByOrderID($orderID);
        if (!$orderModel) {
            throw new NotFoundHttpException();
        }

        if ($orderModel->status != Order::STATUS_PENDING_PAY) {
            throw new NotFoundHttpException();
        }

        return $orderModel;
    }

    public function actionWechatPayInfo()
    {
        $orderModel = $this->getOrderModel();
        $openID     = (new AuthWechat())->getByUserID(UserSession::getId())->getOpenID();
        $response   = Wechat::createJSOrder($openID, $orderModel->name, $orderModel->order_id, $orderModel->price);
        if ($response === false) {
            return Json::error("非法请求");
        }

        return Json::success($response);
    }


    public function actionCodeInfo()
    {
        $codeID = Request::input("code");
        $model  = PromotionCard::getByCardNumber($codeID);
        if (!$model) {
            return Json::error("卡号不存在");
        }

        return Json::success($model->card_worth);
    }
}
