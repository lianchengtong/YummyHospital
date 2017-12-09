<?php
return [
    'language'   => "zh-CN",
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db'    => [
            'class'    => 'yii\db\Connection',
            'dsn'      => 'mysql:host=localhost;dbname=yummy_hospital',
            'username' => 'root',
            'password' => 'admin',
            'charset'  => 'utf8',
        ],
    ],
];
