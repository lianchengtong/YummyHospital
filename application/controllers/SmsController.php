<?php

namespace application\controllers;

use application\base\WebController;
use common\models\SmsHistory;
use common\models\WebsiteConfig;
use common\utils\AliyunSMS;
use common\utils\Cache;
use common\utils\Json;
use common\utils\Request;

class SmsController extends WebController
{
    public function actionSend()
    {

        $code       = mt_rand(100000, 999999);
        $phone      = Request::input("phone");
        $templateID = WebsiteConfig::getValueByKey("site.aliyun.sms_template_id");

        $cacheTimeKey   = sprintf("%s_%s", date("Ymd"), $phone);
        $todaySendTimes = intval(Cache::get($cacheTimeKey));
        if ($todaySendTimes > 5) {
            return Json::error("今天发送次数到达上限");
        }

        $cacheSendLockKey = sprintf("lock_%s", $phone);
        if (Cache::get($cacheSendLockKey)) {
            return Json::error("您发送的频率太快了,请稍后");
        }

        $isSuccess = AliyunSMS::sendSms($phone, $templateID, [
            'code' => $code,
        ]);

        SmsHistory::addMessage($phone, $isSuccess, AliyunSMS::getLastResponse());
        if ($isSuccess) {
            Cache::set($phone, $code, 30 * 60);
            Cache::set($cacheSendLockKey, 1, 60);

            return Json::success();
        }
        return Json::error();
    }
}