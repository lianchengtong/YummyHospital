<?php

namespace application\controllers;


use application\base\BaseController;
use common\models\Order;
use common\utils\pay\Wechat;

class CallbackController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionWechat()
    {
        $response = Wechat::processCallback();
        if ($response == false) {
            return "INVALID";
        }

        $trans = \Yii::$app->getDb()->beginTransaction();
        try {
            $totalFee    = $response['total_fee'];
            $outTradeNum = $response['transaction_id'];
            $orderID     = $response['out_trade_no'];

            $orderModel = Order::getByOrderID($orderID);
            if (!$orderModel) {
                throw new \Exception("order not exist!");
            }

            if ($orderModel->status != Order::STATUS_PENDING_PAY) {
                return Wechat::callbackOkString();
            }

            if ($totalFee != $orderModel->price) {
                throw new \Exception("total fee not match db fee");
            }

            if (!$orderModel->completeWithTradeNumber($outTradeNum, Order::CHANNEL_WECHATPAY)) {
                throw new \Exception("set to complete status fail");
            }

            $orderModel->runCallbacks();

            $trans->commit();

            return Wechat::callbackOkString();
        } catch (\Exception $e) {
            $trans->rollBack();

            return $e->getMessage();
        }
    }
}
