<?php

namespace application\controllers;

use application\base\WebController;
use common\models\AuthWechat;
use common\models\Order;
use common\utils\Json;
use common\utils\pay\Wechat;
use common\utils\Request;
use common\utils\UserSession;
use yii\web\NotFoundHttpException;

class OrderController extends WebController
{
    public function actionList()
    {
        echo "list";
    }

    public function actionPay()
    {
        $orderModel = $this->getOrderModel();

        return "pay page";
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

    public function actionWechatPay()
    {
        $orderModel = $this->getOrderModel();

        return $this->output("page.order-pay", [
            'model' => $orderModel,
        ], [
            'title'      => "订单支付",
            'showGoBack' => true,
            'showTab'    => false,
        ]);
    }

    public function actionPayInfo()
    {
        $orderModel = $this->getOrderModel();
        $openID     = (new AuthWechat())->getByUserID(UserSession::getId())->getOpenID();
        $response   = Wechat::createJSOrder($openID, $orderModel->name, $orderModel->order_id, $orderModel->price);
        if ($response === false) {
            return Json::error("非法请求");
        }

        return Json::success($response);
    }

}
