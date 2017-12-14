<?php

namespace common\utils;


use common\models\WebsiteConfig;
use yii\base\Component;

class Mailer extends Component
{
    private static $_mailer;

    /**
     * @return null|object|\yii\swiftmailer\Mailer
     */
    public static function instance()
    {
        if (!is_null(self::$_mailer)) {
            return self::$_mailer;
        }

        $configData = WebsiteConfig::getMultiValue([
            'email.smtp.host',
            'email.smtp.port',
            'email.smtp.username',
            'email.smtp.password',
            'email.smtp.nickname',
        ]);


        $mailerConfig = [
            'class'            => 'yii\swiftmailer\Mailer',
            'viewPath'         => '@common/mail',
            'useFileTransport' => false,
            'transport'        => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => $configData['email.smtp.host'],
                'username'   => $configData['email.smtp.username'],
                'password'   => $configData['email.smtp.password'] ?: ALIYUN_MAIL_SMTP_PASSWORD,
                'port'       => $configData['email.smtp.port'],
                'encryption' => 'tls',
            ],
            'messageConfig'    => [
                'charset' => 'UTF-8',
                'from'    => [
                    $configData['email.smtp.username'] => $configData['email.smtp.nickname'],
                ],
            ],
        ];
        try {
            self::$_mailer = \Yii::createObject($mailerConfig);
        } catch (\Exception $e) {
            return null;
        }
        return self::$_mailer;
    }
}