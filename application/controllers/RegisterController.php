<?php

namespace application\controllers;


use application\base\WebController;
use common\models\User;
use common\utils\Cache;
use common\utils\Request;
use common\utils\UserSession;

class RegisterController extends WebController
{
    public $layoutSnip = "main";

    public function actionIndex()
    {
        if (!UserSession::isGuest()) {
            return $this->goBack();
        }

        $model  = new User();
        $errors = [];
        if (Request::isPost() && $model->load(Request::input())) {
            $cacheCode = Cache::get("register:" . $model->phone);
            if ($model->code != $cacheCode) {
                $errors[] = "验证码错误";
            } else {
                $model->setPassword($model->password);
                $model->generateAuthKey();

                if ($model->save() && UserSession::login($model)) {
                    $this->redirect("/");
                }
            }
        }

        return $this->output('page.register', [
            'model'  => $model,
            'errors' => $errors,
        ], [
            'title' => '用户注册',
        ]);
    }
}