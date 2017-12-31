<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Order;
use common\utils\Json;
use common\utils\pay\Wechat;
use common\utils\Request;
use yii\web\NotFoundHttpException;

class OrderController extends WebController
{
    public function actionList()
    {
        echo "list";
    }

    public function actionPay()
    {
        $orderID    = Request::input("id");
        $orderModel = Order::getByOrderID($orderID);
        if (!$orderModel) {
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

        $openID   = 'oxrAn08P7FtjKly1n3XinIg1BFMQ';
        $response = Wechat::createJSOrder($openID, $orderModel->name, $orderModel->order_id, $orderModel->price);
        if ($response === false) {
            return Json::error("非法请求");
        }

        return Json::success($response);
    }
}
