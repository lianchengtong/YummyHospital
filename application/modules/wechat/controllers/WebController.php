<?php

namespace application\modules\wechat\controllers;

use application\base\WeChatWebBaseController;
use common\extend\Url;
use common\utils\WeChatInstance;

class WebController extends WeChatWebBaseController
{
    public function actionIndex()
    {
        $app = WeChatInstance::officialAccount();
        try {
            $redirectTo = Url::full(["@wechat/web/callback"]);
            $app->oauth->scopes(['snsapi_userinfo'])
                       ->setRedirectUrl($redirectTo)
                       ->redirect()
                       ->send();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    public function actionCallback()
    {
        $app = WeChatInstance::officialAccount();
        try {
            $userInfo = $app->oauth->user()->toArray();
            print_r($userInfo);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
