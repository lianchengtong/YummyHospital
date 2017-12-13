<?php

namespace application\modules\wechat\controllers;

use application\base\BaseController;
use application\base\WechatBaseController;
use application\base\WeChatMessageBaseController;
use common\models\search\WebsiteConfig;
use EasyWeChat\Factory;

class DefaultController extends WeChatMessageBaseController
{
    public function actionIndex()
    {
        $wechatAppID = WebsiteConfig::getValueByKey("wechat.app_id");
        $wechatAppSecret = WebsiteConfig::getValueByKey("wechat.app_secret");
        $wechatToken = WebsiteConfig::getValueByKey("wechat.token");

        $config = [
            'app_id' => $wechatAppID,
            'secret' => $wechatAppSecret,
            'token'  => $wechatToken,
            'log'    => [
                'level' => 'debug',
                'file'  => \Yii::getAlias('@runtime/logs/wechat.log'),
            ],
        ];

        $app = Factory::officialAccount($config);
        try {
            $app->server->push(function ($message) use ($app) {
                switch ($message['MsgType']) {
                    case 'event':
                        return '收到事件消息';
                        break;
                    case 'text':
                        return '收到文字消息:' . json_encode($app->server->getMessage());
                        break;
                    case 'image':
                        return '收到图片消息';
                        break;
                    case 'voice':
                        return '收到语音消息';
                        break;
                    case 'video':
                        return '收到视频消息';
                        break;
                    case 'location':
                        return '收到坐标消息';
                        break;
                    case 'link':
                        return '收到链接消息';
                        break;
                    default:
                        return '收到其它消息';
                        break;
                }
            });

            $response = $app->server->serve();
            return $response->getContent();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
