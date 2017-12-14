<?php

namespace application\modules\wechat\controllers;

use application\base\WeChatMessageBaseController;
use common\utils\WeChatInstance;

class DefaultController extends WeChatMessageBaseController
{
    public function actionIndex()
    {
        $app = WeChatInstance::officialAccount();
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
