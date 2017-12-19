<?php

namespace rogeecn\UnSlider;

use yii\web\AssetBundle;

class SwipeAsset extends AssetBundle {

    public $js = [
        'js/jquery.event.swipe.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'rogeecn\UnSlider\MoveAsset'
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
    }
}
