<?php

namespace application\controllers;


use application\base\WebController;
use common\models\User;
use common\utils\Cache;
use common\utils\Request;
use common\utils\UserSession;

class LoginController extends WebController
{
    public $layoutSnip = "main";

    public function actionIndex()
    {
        if (!UserSession::isGuest()) {
            return $this->goBack();
        }

        $model  = new User();
        $errors = [];
        $mode   = Request::input("mode", "password");
        if (Request::isPost() && $model->load(Request::input())) {
            if ($mode == "password") {
                $password = $model->password;

                /** @var User $model */
                $model = User::getByPhone($model->phone);
                if ($model->validatePassword($password)) {
                    UserSession::login($model);

                    return $this->redirect("/");
                }
                $errors[] = "密码错误";
            } else {
                $cacheCode = Cache::get("login:" . $model->phone);
                if ($cacheCode != $model->code) {
                    $errors[] = "验证码错误！";
                } else {
                    $model = User::getByPhone($model->phone);
                    if (!$model) {
                        $errors[] = "用户不存在";
                    } else {
                        UserSession::login($model);

                        return $this->redirect("/");
                    }
                }
            }

        }

        $this->getView()->errors = $errors;

        return $this->output('page.login', [
            'model' => $model,
            'mode'  => Request::input("mode", "password"),
        ], [
            'title' => '用户登录',
        ]);
    }
}