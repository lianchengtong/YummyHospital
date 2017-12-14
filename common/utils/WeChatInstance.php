<?php

namespace common\utils;


use common\models\AuthWechat;
use common\models\WebsiteConfig;
use EasyWeChat\Factory;

class WeChatInstance
{
    private static $_instance;

    /**
     * @return \EasyWeChat\OfficialAccount\Application
     */
    public static function officialAccount()
    {
        if (isset(self::$_instance['officialAccount'])) {
            return self::$_instance['officialAccount'];
        }

        self::$_instance['officialAccount'] = Factory::officialAccount(self::getConfig());
        return self::$_instance['officialAccount'];
    }

    private static function getConfig()
    {
        $appID     = WebsiteConfig::getValueByKey("wechat.app_id");
        $appSecret = WebsiteConfig::getValueByKey("wechat.app_secret");
        $token     = WebsiteConfig::getValueByKey("wechat.token");

        $refreshToken = "";
        if (!UserSession::isGuest()) {
            $authUser     = UserSession::identity()->getAuthAccount(AuthWechat::AUTH_TYPE);
            $refreshToken = $authUser->getRefreshToken();
        }

        $config = [
            'app_id'        => $appID,
            'secret'        => $appSecret,
            'token'         => $token,
            'refresh_token' => $refreshToken,
            'cache'         => \Yii::$app->cache,
            'log'           => [
                'level' => 'debug',
                'file'  => \Yii::getAlias('@runtime/logs/wechat.log'),
            ],
        ];

        return $config;
    }

    /**
     * @return \EasyWeChat\Payment\Application
     */
    public static function payment()
    {
        if (isset(self::$_instance['payment'])) {
            return self::$_instance['payment'];
        }

        self::$_instance['payment'] = Factory::payment(self::getConfig());
        return self::$_instance['payment'];
    }

    /**
     * @return \EasyWeChat\MiniProgram\Application
     */
    public static function miniProgram()
    {
        if (isset(self::$_instance['miniProgram'])) {
            return self::$_instance['miniProgram'];
        }

        self::$_instance['miniProgram'] = Factory::miniProgram(self::getConfig());
        return self::$_instance['miniProgram'];
    }


    /**
     * @return \EasyWeChat\OpenPlatform\Application
     */
    public static function openPlatform()
    {
        if (isset(self::$_instance['openPlatform'])) {
            return self::$_instance['openPlatform'];
        }

        self::$_instance['openPlatform'] = Factory::openPlatform(self::getConfig());
        return self::$_instance['openPlatform'];
    }

    /**
     * @return \EasyWeChat\BasicService\Application
     */
    public static function basicService()
    {
        if (isset(self::$_instance['basicService'])) {
            return self::$_instance['basicService'];
        }

        self::$_instance['basicService'] = Factory::basicService(self::getConfig());
        return self::$_instance['basicService'];
    }
}