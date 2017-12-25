<?php

namespace application\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css      = [
//        '//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css',
//        "//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css",
'css/site.css',
    ];
    public $js       = [
//        "js/common.js",
//"js/zepto.min.js",
//"js/frozen.js",
    ];
    public $depends  = [
//        'yii\web\JqueryAsset',
    ];
}
