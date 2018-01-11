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

class PayController extends WebController
{
    public function actionIndex()
    {
        $orderModel = $this->getOrderModel();

        return $this->render("index", [
            'model'   => $orderModel,
        ]);
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

    public function actionWechatPayInfo()
    {
        $orderModel = $this->getOrderModel();
        $openID = (new AuthWechat())->getByUserID(UserSession::getId())->getOpenID();
        $response = Wechat::createJSOrder($openID, $orderModel->name, $orderModel->order_id, $orderModel->price);
        if ($response === false) {
            return Json::error("非法请求");
        }

        return Json::success($response);
    }

}
