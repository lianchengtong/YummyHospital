<?php

namespace rogeecn\UnSlider;

use yii\web\AssetBundle;

class UnSliderAsset extends AssetBundle
{
    public $js = [
        'js/jquery.event.swipe.js',
        'js/jquery.event.move.js',
        'js/unslider.min.js',
    ];

    public $css = [
        'css/unslider.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";

        parent::init();
    }
}
