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
    public $enableCsrfValidation = false;

    public function actionList()
    {
        echo "list";
    }

    public function actionWechatPay()
    {
        $orderID    = Request::input("id");
        $orderModel = Order::getByOrderID($orderID);
        if (!$orderModel) {
            throw new NotFoundHttpException();
        }

        if ($orderModel->status != Order::STATUS_PENDING_PAY) {
            throw new NotFoundHttpException();
        }

        return $this->render("pay", [
            'model' => $orderModel,
        ]);
    }

    public function actionPayInfo()
    {
        $orderID    = Request::input("id");
        $orderModel = Order::getByOrderID($orderID);
        if (!$orderModel) {
            throw new NotFoundHttpException();
        }

        if ($orderModel->status != Order::STATUS_PENDING_PAY) {
            throw new NotFoundHttpException();
        }

        $openID   = (new AuthWechat())->getByUserID(UserSession::getId())->getOpenID();
        $response = Wechat::createJSOrder($openID, $orderModel->name, $orderModel->order_id, $orderModel->price);
        if ($response === false) {
            return Json::error("非法请求");
        }

        return Json::success($response);
    }

}
