<?php

namespace application\controllers;

use application\base\WebController;
use common\models\MemberCard;
use common\models\MemberCardPayLog;
use common\models\MemberOwnCard;
use common\models\Order;
use common\models\OrderMontData;
use common\utils\Request;
use common\utils\UserSession;
use yii\web\NotFoundHttpException;

class CardController extends WebController
{
    public function actionIndex()
    {
        $models = MemberCard::find()->orderBy(['order' => SORT_ASC])->all();

        return $this->setViewData([
            'title'   => '会员卡列表',
            'showTab' => false,
        ])->output("page.card-list", [
            'models' => $models,
        ]);
    }

    public function actionHistory()
    {
        $myCard    = MemberOwnCard::getUserEnableCard(UserSession::getId());
        $condition = [
            'card_id' => $myCard->id,
        ];
        $models    = MemberCardPayLog::find()->where($condition)->orderBy(['id' => SORT_DESC])->all();

        return $this->setViewData([
            'title' => '会员卡消费记录',
        ])->output("page.card-history", [
            'models' => $models,
        ]);
    }

    public function actionRules()
    {
        return $this->setViewData([
            'title'   => '会员卡使用须知',
            'showTab' => false,
        ])->output("page.card-rules");
    }

    public function actionDetail($id)
    {
        $model = MemberCard::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $this->setViewData([
            'title' => $model->name,
        ])->output("card.detail", [
            'model' => $model,
        ]);
    }

    public function actionMine()
    {
        $model = MemberOwnCard::getUserEnableCard(UserSession::getId());
        if (!$model) {
            $this->redirect(['/card/index']);
        }

        return $this->setViewData([
            'title' => '我的会员卡',
        ])->output("card.mine", [
            'model' => $model,
        ]);
    }


    public function actionBuy($id)
    {
        /** @var MemberCard $model */
        $model = MemberCard::getByID($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        // 如果当前用户会员卡权限大于购买卡则报错
        $userID       = UserSession::getId();
        $ownCardModel = null;
        if (MemberOwnCard::isUserHasCard($userID)) {
            $ownCardModel = MemberOwnCard::getUserEnableCard($userID);
            if ($ownCardModel->memberCard->order <= $model->order) {
                throw new NotFoundHttpException();
            }
        }

        $goodPrice = $model->price * $model->discount / 100;
        $trans     = \Yii::$app->getDb()->beginTransaction();

        try {
            // order create
            $title      = sprintf("会员卡 %s 购买", $model->name);
            $orderModel = Order::create(UserSession::getId(), $title, $goodPrice);
            if ($orderModel === false) {
                throw new \Exception("create order failed");
            }

            $montDataCallback = OrderMontData::getCallback(MemberOwnCard::className(), "callbackPaySuccess", [$model->id]);
            $montDataList     = [
                'enableCard'               => '0',
                'enableCoin'               => '0',
                'enableCode'               => '0',
                'callback'                 => $montDataCallback,
                MemberCard::rawTableName() => $model->id,
            ];

            $montData = OrderMontData::addBatchData($orderModel->primaryKey, $montDataList);
            if (true !== $montData) {
                throw new \Exception("save order mont data fail");
            }

            $trans->commit();

            return $this->redirect(['pay/index', 'id' => $orderModel->order_id]);
        } catch (\Exception $e) {
            $trans->rollBack();
            $this->addError($e->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionCharge()
    {
        $model = MemberOwnCard::getUserEnableCard(UserSession::getId());
        if (!$model) {
            return $this->redirect(['/card/index']);
        }

        if (Request::isPost()) {

            $goodPrice = floatval(Request::input("amount"));
            if ($goodPrice <= 10) {
                $model->addError("id", "请输入合法充值金额");
            } else {
                $trans = \Yii::$app->getDb()->beginTransaction();

                try {
                    // order create
                    $title      = sprintf("%s 会员卡充值", $model->card->name);
                    $orderModel = Order::create(UserSession::getId(), $title, $goodPrice);
                    if ($orderModel === false) {
                        throw new \Exception("create order failed");
                    }

                    $montDataCallback = OrderMontData::getCallback(
                        MemberOwnCard::className(),
                        "callbackChargeSuccess",
                        [$model->id]
                    );
                    $montDataList     = [
                        'enableCard'                  => '0',
                        'enableCoin'                  => '0',
                        'enableCode'                  => '0',
                        'callback'                    => $montDataCallback,
                        MemberOwnCard::rawTableName() => $model->id,
                    ];

                    $montData = OrderMontData::addBatchData($orderModel->primaryKey, $montDataList);
                    if (true !== $montData) {
                        throw new \Exception("save order mont data fail");
                    }

                    $trans->commit();

                    return $this->redirect(['pay/index', 'id' => $orderModel->order_id]);
                } catch (\Exception $e) {
                    $trans->rollBack();
                    $this->addError($e->getMessage());
                }
            }
        }

        return $this->setViewData([
            'title' => '会员卡充值',
        ])->output("page.card-charge", [
            'model' => $model,
        ]);
    }
}
