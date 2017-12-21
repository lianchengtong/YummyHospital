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
        echo Html::tag("h3", $configItem->name, ['class' => 'text-center text-primary', 'style' => 'margin: 30px 0  20px 0;padding-bottom: 10px;border-bottom:1px solid #dddddd']);
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
