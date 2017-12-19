<?php

namespace rogeecn\UnSlider;

use yii\web\AssetBundle;

class UnSliderDefaultAsset extends AssetBundle
{

    public $baseUrl = '';

    public $css = [
        'css/style.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'rogeecn\UnSlider\UnsliderAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
    }
}

