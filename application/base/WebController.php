<?php

namespace application\base;

use common\extend\Url;
use common\models\AuthWechat;
use common\utils\Request;
use common\utils\Session;
use common\utils\UserSession;
use common\utils\WeChatInstance;
use EasyWeChat\OfficialAccount\Application;

class WebController extends BaseController
{
    public    $layoutSnip = "tab_nav";
    protected $needLogin  = false;

    /** @var Application */
    protected $app;

    public function beforeAction($action)
    {
//        /*
        $this->app = WeChatInstance::officialAccount();
        $userInfo = Session::get("wechat.user");
        if (!$userInfo) {
            if (!$this->isAuthCallbackPage()) {
                $this->gotoAuthPage();

                return false;
            }

            if ($this->isAuthCallbackPage()) {
                if (!$this->setSessionUserInfo()) {
                    return false;
                }

                $url = Request::input("redirect");
                $this->redirect($url);

                return false;
            }
        }

        if ($this->isAuthCallbackPage()) {
            $url = Request::input("redirect");
            if (!empty($url)) {
                $this->redirect($url);

                return false;
            }
        }

        if ($this->needLogin && UserSession::isGuest()) {
            $authUserModel = AuthWechat::getByOpenID($userInfo['token']['openid']);
            if ($authUserModel) {
                $authUserModel->setAuthData($userInfo['token']);
                if (!$authUserModel->user->setUserAuth($authUserModel)) {
                    throw new \Exception("更新用户授权失败!");
                }

                if (!UserSession::login($authUserModel->user)) {
                    throw new \Exception("自动登录失败");
                }

                return parent::beforeAction($action);
            }

            $this->redirect(Url::full(['/login/index']));

            return false;
        }
//        */
        return parent::beforeAction($action);
    }

    protected function isAuthCallbackPage()
    {
        $isAuthCallback = Request::get("code") && Request::get("state");

        return $isAuthCallback;
    }

    private function getCurrentRoute()
    {
        return sprintf("%s/%s", $this->module->uniqueId, $this->action->uniqueId);
    }

    protected function gotoAuthPage()
    {
        $redirectTo = Url::full([$this->getCurrentRoute()]);
        $redirectTo = Url::full(["/", 'redirect' => $redirectTo]);

        //scope: snsapi_base, snsapi_userinfo
        $app = WeChatInstance::officialAccount();
        $app->oauth->scopes(['snsapi_userinfo'])
                   ->setRedirectUrl($redirectTo)
                   ->redirect()
                   ->send();
    }

    protected function setSessionUserInfo()
    {
        try {
            $authUserInfo = $this->app->oauth->user();
            $accessToken = $authUserInfo->getAccessToken();
            $authTokenArr = [
                'access_token'  => $accessToken->access_token,
                'refresh_token' => $accessToken->refresh_token,
                'expire_at'     => $accessToken->expires_in,
                'open_id'       => $accessToken->openid,
            ];
            Session::set("wechat.user", $authUserInfo);

            $authUserModel = AuthWechat::getByOpenID($accessToken->openid);
            if (!$authUserModel) {
                return true;
            }

            return UserSession::login($authUserModel->user);
        } catch (\Exception $e) {
            return false;
        }
    }
}