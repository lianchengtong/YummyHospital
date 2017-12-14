<?php

namespace application\controllers;

use application\base\BaseController;
use common\models\AuthWechat;
use common\models\User;
use common\utils\Json;

class TestController extends BaseController
{
    public function actionIndex()
    {
        $user     = new User();
        $userInfo = [
            'phone'         => '182123123',
            'email'         => 'rog12323eecn@qq.com',
            'password_hash' => User::randomPassword(),
        ];
        if (!$user->registerUser($userInfo)) {
            return Json::error($user->getErrors());
        }

        $userAuth = new AuthWechat();
        $userAuth->setAuthData([
            'access_token'  => "123123",
            'refresh_token' => "123123",
            'expire_at'     => 7200,
            'open_id'       => 7200,
        ]);
        $ret = $user->setUserAuth($userAuth);
        return Json::success($ret);
    }
}
