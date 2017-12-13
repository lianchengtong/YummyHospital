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

        $config = [
            'app_id' => $wechatAppID,
            'secret' => $wechatAppSecret,
            'log'    => [
                'level' => 'debug',
                'file'  => \Yii::getAlias('@runtime/logs/wechat.log'),
            ],
        ];

        $app      = Factory::officialAccount($config);
        $response = $app->server->serve();

        return $response->getContent();
    }
}
