<?php

namespace application\controllers;

use application\base\BaseController;
use common\utils\Mailer;

class TestController extends BaseController
{
    public function actionIndex()
    {
        $email  = "rogeecn@qq.com";
        $mailer = Mailer::instance()->compose("verifyEmailAddress", [
            'code' => mt_rand(100000, 999999),
        ]);
        $mailer->setTo($email);
//        $mailer->setSubject($mailsubject);
        $mailer->setSubject("你好，请验证您的邮箱地址！");

        if ($mailer->send()) {
            return "发送成功,请登录您的注册邮箱查收邮件!";
        }
        return "发送失败,请重新尝试发送!";
    }
}
