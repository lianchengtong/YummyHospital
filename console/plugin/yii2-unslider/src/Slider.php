<?php

namespace rogeecn\UnSlider;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Class Slider
 *
 * http://idiot.github.io/unslider/
 * @package rogeecn\UnSlider
 */
class Slider extends Widget
{
    public $containerOptions = ['class' => "banner"];
    public $slides           = [];
    public $slidesOptions    = [];

    public $options = [
        'nav'   => true,
        'keys'  => false,
        'fluid' => true,
    ];

    public function init()
    {
        parent::init();
        UnSliderAsset::register($this->getView());

        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->getId();
        }
    }

    public function run()
    {
        $this->registerScripts();

        $slides = [];
        foreach ($this->slides as $index => $slide) {
            if (!isset($slide['options'])) {
                $slide['options'] = [];
            }

            if (isset($slide['image'])) {
                $slideContent = Html::img($slide['img']);
            } else {
                $slideContent = Html::tag("div", $slide['body']);
            }

            if (isset($slide['url'])) {
                $slideContent = Html::a($slideContent, $slide['url'], ['encode' => false]);
            }

            if (!isset($slide['options']['data-nav'])) {
                $slide['options']['data-nav'] = $index;
            }
            $slides[] = Html::tag("li", $slideContent, $slide['options']);
        }

        $slideHtml = Html::tag("ul", implode("\n", $slides), $this->slidesOptions);

        return Html::tag("div", $slideHtml, $this->containerOptions);
    }

    private function registerScripts()
    {
        $options = Json::htmlEncode($this->mergeOptions());
        $js      = <<<_CODE
$("#{$this->containerOptions['id']}").unslider($options);
_CODE;

        $this->getView()->registerJs($js);
    }

    private function mergeOptions()
    {
        $defaultOptions = $this->defaultOptions();
        return ArrayHelper::merge($defaultOptions, $this->options);
    }

    private function defaultOptions()
    {
        //noloop: The opposite of infinite: true, this will stop the slider looping around at all.
        //        Will not work if infinite is set.
        //
        // animation:
        // 'horizontal', which moves the slides from left-to-right
        // 'vertical', which moves the slides from top-to-bottom
        // 'fade', which crossfades slides
        return [
            "infinite"    => true,
            "noloop"      => false,
            "autoplay"    => false,
            "arrows"      => false, // show prev or next
            "keys"        => false,
            "nav"         => true,
            "fluid"       => true,
            "animation"   => "horizontal",
            "activeClass" => "unslider-active",
            "speed"       => 750,
            "delay"       => 3000,
            "complete"    => new JsExpression("function(){}"),
        ];
    }
}
