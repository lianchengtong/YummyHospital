<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'YummyHospital',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'defaultRoute'        => 'index',
    'controllerNamespace' => 'application\controllers',
    'aliases'             => [
        '@rogeecn/SimpleAjaxUploader' => '@console/plugin/yii2-simple-ajax-uploader/src',
        '@rogeecn/UnSlider'           => '@console/plugin/yii2-unslider/src',
        '@rogeecn/AceEditor'          => '@console/plugin/yii2-ace-editor/src',
    ],
    'modules'             => [
        'manage' => [
            'class' => 'application\modules\manage\Module',
        ],
        'wechat' => [
            'class' => 'application\modules\wechat\Module',
        ],
    ],
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf_yummy_hospital',
        ],
        'cache'        => [
            'class' => '\yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl'        => ['/manage/login'],
        ],
        'session'      => [
            'name' => 'sess_yumm_hospital',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => '/error/index',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '/test-wechatpay' => 'test/go',
            ],
        ],
        'formatter'    => [
            'dateFormat'     => 'php:y/m/d',
            'datetimeFormat' => 'php:y/m/d H:i',
            'timeFormat'     => 'php:H:i:s',
        ],
        'view'         => [
            'class' => 'common\extend\View',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset'                => [
                    'jsOptions' => [
                        'position' => \yii\web\View::POS_HEAD,
                    ],
                    'js'        => [
                        '//cdn.staticfile.org/jquery/3.2.1/jquery.min.js',
                    ],
                ],
                'yii\bootstrap\BootstrapAsset'       => [
                    'css' => [
                        '//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css',
                    ],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        '//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js',
                    ],
                ],
                'plugins\FontAwesome\FontAwesome'    => [
                    'css' => [
                        '//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css',
                    ],
                ],
            ],
        ],
    ],
    'params'              => $params,
];
