<?php

namespace application\modules\wechat\controllers;

use application\base\BaseController;
use common\models\search\WebsiteConfig;
use EasyWeChat\Factory;

class DefaultController extends BaseController
{
    public function actionIndex()
    {
        $wechatAppID     = WebsiteConfig::getValueByKey("wechat.app_id");
        $wechatAppSecret = WebsiteConfig::getValueByKey("wechat.app_secret");
        $wechatToken = WebsiteConfig::getValueByKey("wechat.token");

        $config = [
            'app_id' => $wechatAppID,
            'secret' => $wechatAppSecret,
            'token' => $wechatToken,
            'log'    => [
                'level' => 'debug',
                'file'  => \Yii::getAlias('@runtime/logs/wechat.log'),
            ],
        ];

        $app      = Factory::officialAccount($config);
        try{
            $response = $app->server->serve();

            $app->server->push(function($message){
                return "hello";
            });


            return $response->getContent();
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
}
