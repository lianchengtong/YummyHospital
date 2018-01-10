<?php

namespace application\controllers;

use application\base\WebController;
use common\models\MemberCard;
use common\models\MemberOwnCard;
use common\models\Order;
use common\models\OrderMontData;
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

    public function actionMine()
    {
        $model = MemberOwnCard::getUserEnableCard(UserSession::getId());

        return $this->render("mine", [
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
                'callback'                 => $montDataCallback,
                MemberCard::rawTableName() => $model->id,
            ];

            $montData = OrderMontData::addBatchData($orderModel->primaryKey, $montDataList);
            if (true !== $montData) {
                throw new \Exception("save order mont data fail");
            }

            $trans->commit();

            return $this->redirect(['order/pay', 'id' => $orderModel->order_id]);
        } catch (\Exception $e) {
            $trans->rollBack();
            $this->addError($e->getMessage());
        }

        return $this->redirect(['index']);
    }
}
