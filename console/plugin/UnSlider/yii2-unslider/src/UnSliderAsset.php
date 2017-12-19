<?php

namespace rogeecn\UnSlider;

use yii\web\AssetBundle;

class UnSliderAsset extends AssetBundle
{
    public $js = [
        'js/unslider-min.js',
    ];

    public $depends = [
        'rogeecn\UnSlider\SwipeAsset',
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
    }
}
