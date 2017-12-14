<?php

namespace application\modules\wechat\controllers;

use application\base\WeChatWebBaseController;
use common\extend\Url;
use common\models\AuthWechat;
use common\models\User;
use common\utils\Request;
use common\utils\UserSession;
use common\utils\WeChatInstance;
use yii\base\Exception;

class WebController extends WeChatWebBaseController
{
    protected $app;

    public function actionIndex()
    {
        $this->app = WeChatInstance::officialAccount();

        if (!$this->isAuthCallbackPage() && UserSession::isGuest()) {
            $this->gotoAuthPage();
            return false;
        }

        if ($this->isAuthCallbackPage() && !$this->initUserInfo()) {
            return false;
        }

        $redirectTo = Request::input("__redirect");
        return $this->redirect($redirectTo ?: ['callback']);
    }

    protected function isAuthCallbackPage()
    {
        $isAuthCallback = Request::get("code") && Request::get("state");
        return $isAuthCallback;
    }

    protected function gotoAuthPage()
    {
        $redirectTo = Request::input("__redirect");
        $redirectTo = Url::full(["@wechat/web", 'redirect' => $redirectTo]);

        $app = WeChatInstance::officialAccount();
        $app->oauth->scopes(['snsapi_userinfo'])
                   ->setRedirectUrl($redirectTo)
                   ->redirect()
                   ->send();
    }

    protected function initUserInfo()
    {
        try {
            $authUserInfo = $this->app->oauth->user();
            $accessToken  = $authUserInfo->getAccessToken();
            $authTokenArr = [
                'access_token'  => $accessToken->access_token,
                'refresh_token' => $accessToken->refresh_token,
                'expire_at'     => $accessToken->expires_in,
                'open_id'       => $accessToken->openid,
            ];

            $userModel = UserSession::identity();
            if (!$userModel) {
                $userModel = $this->registerUser($authUserInfo);
            }

            $authUserModel = AuthWechat::getByOpenID($accessToken->openid);
            if (!$authUserModel) {

                $authUserModel = new AuthWechat();
            }

            $authUserModel->setAuthData($authTokenArr);
            if ($userModel->setUserAuth($authUserModel) !== true) {
                throw new Exception("save user auth info fail!");
            }

            if (!UserSession::login($userModel)) {
                throw new Exception("login fail!");
            }

            $authUserModel = $userModel->getAuthAccount(AuthWechat::AUTH_TYPE);
            if ($authUserModel->needRefreshToken()) {
                $refreshToken = $this->app->access_token->getRefreshedToken();
                $authUserModel->updateAccessToken($refreshToken['access_token']);
                $authUserModel->setAccessTokenExpire($refreshToken['expire_in']);
            }

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param \Overtrue\Socialite\User $userInfo
     *
     * @return array|\common\models\User|null|\yii\db\ActiveRecord
     * @throws \yii\base\Exception
     */
    protected function registerUser($userInfo)
    {
        $email     = $userInfo->openid . '@wechat.com';
        $userModel = User::getByEmail($email);
        if ($userModel) {
            return $userModel;
        }

        // register new user
        $userModel = new User();
        $userInfo  = [
            'phone'         => '101' . time(),
            'nickname'      => $userInfo->getNickname(),
            'email'         => $email,
            'password_hash' => User::randomPassword(),
        ];

        if (!$userModel->registerUser($userInfo)) {
            throw new Exception("register new user faild!" . json_encode($userModel->getErrors()));
        }
    }

    public function actionCallback()
    {
        return "hello!";
    }
}
