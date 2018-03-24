<?php

namespace application\controllers;


use application\base\WebController;
use common\models\AuthWechat;
use common\models\User;
use common\utils\Cache;
use common\utils\Request;
use common\utils\Session;
use common\utils\UserSession;

class RegisterController extends WebController
{
    public $layoutSnip = "main";
    public $needLogin  = false;

    public function actionIndex()
    {
        if (!UserSession::isGuest()) {
            return $this->redirect("/");
        }

        $userInfo = Session::get("wechat.user");

        $model  = new User();
        $errors = [];
        if (Request::isPost() && $model->load(Request::input())) {
            try {

                if (User::getByPhone($model->phone)) {
                    throw new \Exception("用户已经存在");
                }
                $cacheCode = Cache::get("register:" . $model->phone);
                if ($model->code != $cacheCode) {
                    throw new \Exception("验证码错误");
                }
                $trans = User::getDb()->beginTransaction();
                try {
                    $model->setPassword($model->password);
                    $model->generateAuthKey();
                    $model->head_image = $userInfo['avatar'];
                    $model->nickname   = $userInfo['name'];
                    $model->email      = sprintf("u-%s@wechat.auth", date("YmdHis"));

                    if (!$model->save()) {
                        throw new \Exception("用户保存失败！");
                    }

                    $authUserModel = new AuthWechat();
                    $authUserModel->setAuthData($userInfo['token']);
                    if (($errData = $model->setUserAuth($authUserModel)) !== true) {
                        throw new \Exception("用户认证保存失败！");
                    }


                    if (!UserSession::login($model)) {
                        throw new \Exception("用户登陆失败！");
                    }


                    Cache::delete("register:" . $model->phone);
                    $trans->commit();

                    return $this->redirect("/");
                } catch (\Exception $e) {
                    $trans->rollBack();
                    $this->addError($e->getMessage());
                }
            } catch (\Exception $e) {
                $this->addError($e->getMessage());
            }

        }

        return $this->setViewData([
            'title'  => '用户注册',
            'errors' => $errors,
        ])->output('page.register', [
            'model' => $model,
        ]);
    }
}