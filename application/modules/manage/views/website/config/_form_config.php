<?php

use common\models\WebsiteConfig;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WebsiteConfig */
/* @var $configItems WebsiteConfig[] */


/** @var WebsiteConfig $configItem */
foreach ($configItems as $configItem) {
    $options = [
        'class' => 'form-control',
        'name'  => $configItem->getFormKey(),
    ];
    if ($configItem->type == WebsiteConfig::TYPE_SPLIT) {
        $span = Html::tag("span", $configItem->name, [
            'style' => 'display:inline-block; background: white; padding: 0 20px;',
        ]);
        echo Html::tag("h3", $span, [
            'class' => 'text-center text-muted',
            'style' => 'margin-top: 40px;margin-bottom: 40px',
        ]);
        echo Html::tag("hr", "", [
            'style' => 'margin-top: -50px',
        ]);
        continue;
    }


    $input = "";
    switch ($configItem->type) {
        case WebsiteConfig::TYPE_STRING:
            $input = Html::activeTextInput($configItem, 'value', $options);
            break;
        case WebsiteConfig::TYPE_TEXT:
            $input = Html::activeTextarea($configItem, 'value', $options);
            break;
        case WebsiteConfig::TYPE_SINGLE_SELECTION:
            $constConf = json_decode($configItem->const_data, true);
            $input     = Html::activeDropDownList($configItem, 'value', $constConf, $options);
            break;
        case WebsiteConfig::TYPE_MULTIPLE_SELECTION:
            $options['multiple'] = true;
            $constConf           = json_decode($configItem->const_data, true);
            $configItem->value   = explode(",", $configItem->value);
            $input               = Html::activeDropDownList($configItem, 'value', $constConf, $options);
            break;
    }

    $hint  = Html::tag("p", $configItem->hint, [
        'class' => 'help-block',
    ]);
    $block = Html::tag("strong", $configItem->key, [
        'class' => 'help-block',
    ]);
    $label = Html::activeLabel($configItem, "name", ['label' => $configItem->name]);

    echo Html::beginTag("div", ['class' => 'form-group']);
    echo Html::beginTag("div", ['class' => 'row']);

    echo Html::beginTag("div", ['class' => 'col-xs-3 text-right', 'style' => 'line-height: 34px']);
    echo Html::tag("strong", $configItem->name);
    echo Html::endTag("div");

    echo Html::beginTag("div", ['class' => 'col-xs-5']);
    echo $input;
    echo $hint;
    echo Html::endTag("div");

    echo Html::beginTag("div", ['class' => 'col-xs-4']);
    echo $block;
    echo Html::endTag("div");

    echo Html::endTag("div");
    echo Html::endTag("div");
}
