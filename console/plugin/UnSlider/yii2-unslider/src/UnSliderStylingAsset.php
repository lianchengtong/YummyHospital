<?php

namespace rogeecn\UnSlider;

use yii\web\AssetBundle;

/**
 * Class UnsliderStylingAsset Defines default unslider styling.
 */
class UnSliderStylingAsset extends AssetBundle
{
    /** @inheritdoc */
    public $css = [
        'css/unslider.css',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
    }
}

