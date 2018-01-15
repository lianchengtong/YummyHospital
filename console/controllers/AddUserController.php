<?php

namespace console\controllers;


use common\models\User;
use common\models\WebsiteConfig;
use common\models\WebsiteConfigGroup;
use console\base\BaseController;

class AddUserController extends BaseController
{
    public function actionIndex($username, $password)
    {
        $user = new User();
        $user->nickname = $username;
        $user->phone = "18601010101";
        $user->email = $username."@admin.com";
        $user->setPassword($password);
        $user->generateAuthKey();

        if ($user->save()) {
            echo "OK\n";
            return;
        }
        print_r($user->getErrors());
    }
}
