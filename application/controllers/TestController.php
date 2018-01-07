<?php

namespace application\controllers;

use application\base\BaseController;
use application\base\WebController;
use common\models\Doctor;
use common\models\Order;
use common\models\PatientFeedback;
use common\utils\Json;
use common\utils\pay\Wechat;

class TestController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $model = Doctor::findOne(1);
        return Json::success($model->doctorServiceTime->price);
        $serviceDate = \common\models\DoctorServiceTime::getAllRecentServiceTimeDateList(1,false);
        return Json::success($serviceDate);

        return Json::success(PatientFeedback::getDoctorMark(1));
        return $this->render("index");
    }

    public function actionGo()
    {
        $openID   = 'oxrAn08P7FtjKly1n3XinIg1BFMQ';
        $response = Wechat::createJSOrder($openID, "test order", Order::generateOrderID(), 1);
        if ($response === false) {
            return Json::error("非法请求");
        }

        return $this->render("go", [
            'data' => $response,
        ]);
    }

    public function actionCallback()
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

            if (!$orderModel->completeWithTradeNumber($outTradeNum)) {
                throw new \Exception("set to complete status fail");
            }

            $trans->commit();
            return Wechat::callbackOkString();
        } catch (\Exception $e) {
            $trans->rollBack();
            return $e->getMessage();
        }

    }
}