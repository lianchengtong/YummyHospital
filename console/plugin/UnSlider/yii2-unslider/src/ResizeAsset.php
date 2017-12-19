<?php

namespace rogeecn\UnSlider;

use yii\web\AssetBundle;

class ResizeAsset extends AssetBundle
{

    /** @inheritdoc */
    public $js = [
        'js/unslider-min.js',
    ];

    /** @inheritdoc */
    public $depends = [
        'yii\web\JqueryAsset',
        'rogeecn\UnSlider\UnSliderAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
    }
}
