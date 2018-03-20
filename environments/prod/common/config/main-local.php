<?php
return [
    'components' => [
        'db'     => [
            'class'               => 'yii\db\Connection',
            'dsn'                 => 'mysql:host=db-master-aliyun-hz.internal.server.ipao.cloud;dbname=yummy_hospital',
            'username'            => 'application',
            'password'            => 'Application@!$)@)@',
            'charset'             => 'utf8',
            'enableSchemaCache'   => TRUE,
            'schemaCacheDuration' => 3600,
        ],
        'mailer' => [
            'class'    => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
