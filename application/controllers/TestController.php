<?php

namespace application\controllers;

use application\base\BaseController;
use common\utils\AliyunSMS;
use common\utils\Json;

class TestController extends BaseController
{
    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionGo()
    {
        $to  = "18601013734";
        $ret = AliyunSMS::sendSms($to, "SMS_117295732", [
            'code' => mt_rand(100000, 999999),
        ]);

        return Json::success($ret);
    }
}