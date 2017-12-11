<?php
return [
    'bootstrap' => ['gii'],
    'modules'   => [
        'gii' => [
            'class'      => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'],
            'generators' => [
                'crud' => [
                    'class'     => 'yii\gii\generators\crud\Generator',
                    'templates' => [
                        'custom' => '@common/extend/gii/templates/crud',
                    ],
                ],
            ],
        ],
    ],
];
