<?php

namespace application\controllers;

use application\base\WebController;
use application\modules\manage\forms\ArticleForm;
use common\models\SmsHistory;
use common\utils\AliyunSMS;
use common\utils\Json;

class TestController extends WebController
{
    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionGo()
    {
        SmsHistory::addAliYunMessage(SmsHistory::TYPE_LOGIN, 2);
        exit;

        $to  = "18601013734";
        $ret = AliyunSMS::sendSms($to, "SMS_119082144", [
            'code' => mt_rand(100000, 999999),
        ]);

        return Json::success($ret);
    }
}