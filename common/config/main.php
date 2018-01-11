<?php
return [
    'language'   => "zh-CN",
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache'  => [
            'class' => 'yii\caching\FileCache',
        ],
        'db'     => [
            'class'    => 'yii\db\Connection',
            'dsn'      => 'mysql:host=mysql;dbname=yummy_hospital',
            'username' => 'root',
            'password' => 'admin',
            'charset'  => 'utf8',
        ],
        'mailer' => [
            'class'            => 'yii\swiftmailer\Mailer',
            'viewPath'         => '@common/mail',
            'useFileTransport' => false,
            'transport'        => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtpdm.aliyun.com',
                'username'   => 'service@mail-service.ipaoyun.com',
                'password'   => ALIYUN_MAIL_SMTP_PASSWORD,
                'port'       => '80',
                'encryption' => 'tls',
            ],
            'messageConfig'    => [
                'charset' => 'UTF-8',
                'from'    => ['service@mail-service.ipaoyun.com' => '爱泡云'],
            ],
        ],
    ],
];
