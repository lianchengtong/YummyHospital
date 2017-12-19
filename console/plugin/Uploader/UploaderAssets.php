<?php

namespace rogeecn\SimpleAjaxImageUploader;

use yii\web\AssetBundle;

class UploaderAssets extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets';
    public $css        = [
    ];
    public $js         = [
        'js/jquery.uploadfile.min.js',
    ];
    public $depends    = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

