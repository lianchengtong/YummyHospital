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
    $input   = "";
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

    $label = Html::activeLabel($configItem, "name", ['label' => $configItem->name]);
    echo Html::tag("div", $label . "\n" . $input, ['class' => 'form-group']);
}
