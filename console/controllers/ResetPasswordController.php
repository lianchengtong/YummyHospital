<?php

namespace console\controllers;


use common\models\User;
use common\models\WebsiteConfig;
use common\models\WebsiteConfigGroup;
use console\base\BaseController;

class ResetPasswordController extends BaseController
{
    public function actionIndex($email, $password)
    {
        $user = User::find()->where(['email' => $email  ])->one();
        $user->setPassword($password);
        $user->generateAuthKey();

        if ($user->save()) {
            echo "OK\n";
            return;
        }
        print_r($user->getErrors());
    }
}
