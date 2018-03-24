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

        $model  = new User();
        $errors = [];
        $mode   = Request::input("mode", "password");
        if (Request::isPost() && $model->load(Request::input())) {
            try {

                if ($mode == "password") {
                    $password = $model->password;

                    if (empty($model->password)) {
                        throw new \Exception("请输入密码");
                    }

                    /** @var User $model */
                    $userModel = User::getByPhone($model->phone);
                    if (!$userModel) {
                        throw new \Exception("手机号还没有注册");
                    }
                    if ($userModel->validatePassword($password)) {
                        UserSession::login($userModel);

                        return $this->redirect("/");
                    }
                    throw new \Exception("密码错误");
                } else {
                    $cacheCode = Cache::get("login:" . $model->phone);
                    if ($cacheCode != $model->code) {
                        throw new \Exception("验证码错误！");
                    }

                    $userModel = User::getByPhone($model->phone);
                    if (!$userModel) {
                        throw new \Exception("用户不存在");
                    }

                    UserSession::login($userModel);
                    Cache::delete("login:" . $model->phone);

                    return $this->redirect("/");
                }
            } catch (\Exception $e) {
                $this->addError($e->getMessage());
            }
        }

        return $this->setViewData([
            'errors' => $errors,
            'title'  => '用户登录',
        ])->output('page.login', [
            'model' => $model,
            'mode'  => Request::input("mode", "password"),
        ]);
    }
}