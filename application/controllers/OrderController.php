<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Order;
use common\utils\Request;
use common\utils\UserSession;
use yii\web\NotFoundHttpException;

class OrderController extends WebController
{
    public function actionList()
    {
        $models = Order::getListByUser(UserSession::getId());

        return $this->setViewData([
            'title'   => '我的订单',
            'showTab' => 'false',
        ])->output("page.order-list", [
            'models' => $models,
        ]);
    }

    public function actionCancelPay()
    {
        $model = $this->getOrderModel();
        if ($model && $model->status == Order::STATUS_PENDING_PAY) {
            $model->status = Order::STATUS_PAY_CLOSED;
            $model->save();
        }

        return $this->redirect(['list']);
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
}
