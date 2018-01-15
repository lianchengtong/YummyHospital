<?php

namespace application\controllers;

use application\base\BaseController;
use common\models\Doctor;
use common\models\Order;
use common\models\PatientAsk;
use common\models\PatientFeedback;
use common\models\PromotionCard;
use common\utils\Json;
use common\utils\pay\Wechat;
use common\utils\WeChatInstance;

class TestController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {

        WeChatInstance::officialAccount()->template_message->send([
//            'touser'      => "oxrAn04zIhnA71kQBHFWzyXoHQQI",
            'touser'      => 'oxrAn08P7FtjKly1n3XinIg1BFMQ',
            'template_id' => 'PD-m5F_le-Y2aSXEXDflFkXM552VO1tmzEYhdsU4jc8',
            'scene'       => 1000,
            'url'         => '',
            'data'        => [
                'first'    => '咨询成功',
                'keyword1' => "在线咨询",
                'keyword2' => "成功",
                'keyword3' => date("Y-m-d H:i:s", $order->complete_at),
                'remark'   => "您咨询的医师将会尽快为您解答问题,请耐心等待。",
            ],
        ]);
        return Json::success();

        $templateID = "jKGnEB9U3y9FK8m54iPeYElrfhHXh6wz4j0EidaKz4k";
        $app = WeChatInstance::officialAccount();
        $result = $app->template_message->send([
            'touser'      => 'oxrAn08P7FtjKly1n3XinIg1BFMQ',
            'template_id' => $templateID,
            'scene'       => 1000,
            'url'         => 'https://baidu.com',
            'data'        => [
                'first'    => '预约成功提醒',
                'keyword1' => date("Y-m-d H:i:s"),
                'keyword2' => "医师预约",
                'keyword3' => "成功",
                'keyword4' => "公众号预约",
                'keyword5' => "公众号预约 杨小小先生的订单",
                'remark'   => "杨小小先生的订单",
            ],
        ]);
        return Json::success($result);


        $model = PatientAsk::getByID(16);

        return Json::error($model->getIsPayed());
        $orderModel = Order::getByOrderID("201801140736245a5b40b8bc7ed00496");
        $orderModel->runCallbacks();
        return Json::success();
        $template = "{date}-{string:10}-{number:5}-{string:5}-{number:10}";
        $data = PromotionCard::generateByTemplate($template);
        var_dump($template);
        var_dump($data);
        exit;
        $model = Doctor::findOne(1);

        return Json::success($model->doctorServiceTime->price);
        $serviceDate = \common\models\DoctorServiceTime::getAllRecentServiceTimeDateList(1, false);

        return Json::success($serviceDate);

        return Json::success(PatientFeedback::getDoctorMark(1));

        return $this->render("index");
    }

    public function actionGo()
    {
        $openID = 'oxrAn08P7FtjKly1n3XinIg1BFMQ';
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
            $totalFee = $response['total_fee'];
            $outTradeNum = $response['transaction_id'];
            $orderID = $response['out_trade_no'];

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