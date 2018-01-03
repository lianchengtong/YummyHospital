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
            return $this->redirect("/");
        }

        $model = new User();
        $errors = [];
        $mode = Request::input("mode", "password");
        if (Request::isPost() && $model->load(Request::input())) {
            if ($mode == "password") {
                $password = $model->password;

                /** @var User $model */
                $userModel = User::getByPhone($model->phone);
                if (!$userModel) {
                    $errors[] = "手机号还没有注册";
                } else {
                    if ($userModel->validatePassword($password)) {
                        UserSession::login($userModel);

                        return $this->redirect("/");
                    }
                    $errors[] = "密码错误";
                }
            } else {
                $cacheCode = Cache::get("login:" . $model->phone);
                if ($cacheCode != $model->code) {
                    $errors[] = "验证码错误！";
                } else {
                    $userModel = User::getByPhone($model->phone);
                    if (!$userModel) {
                        $errors[] = "用户不存在";
                    } else {
                        UserSession::login($userModel);
                        Cache::delete("login:" . $model->phone);

                        return $this->redirect("/");
                    }
                }
            }

        }

        return $this->setViewData([
            'errors' => $errors,
            'title' => '用户登录',
        ])->output('page.login', [
            'model' => $model,
            'mode' => Request::input("mode", "password"),
        ]);
    }
}