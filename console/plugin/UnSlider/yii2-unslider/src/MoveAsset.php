<?php

namespace rogeecn\UnSlider;

use yii\web\AssetBundle;

class MoveAsset extends AssetBundle
{
    public $js = [
        'js/jquery.event.move.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
    }
}
