<?php

namespace application\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css      = [
        'css/site.css',
    ];
    public $js       = [
        "js/jquery.simpler-sidebar.min.js",
        "lib/layer_mobile/layer.js",
    ];
    public $depends  = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        $this->css = [
            'css/site.css?v=' . time(),
        ];
    }
}
