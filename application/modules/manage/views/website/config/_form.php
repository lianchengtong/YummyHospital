<?php

use common\models\WebsiteConfig;
use common\models\WebsiteConfigGroup;

/* @var $this yii\web\View */
/* @var $model common\models\WebsiteConfig */
?>
<?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'hint')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'group_id')->dropDownList(WebsiteConfigGroup::getGroupList()) ?>
<?= $form->field($model, 'type')->dropDownList(WebsiteConfig::getTypeList()) ?>
<?= $form->field($model, 'order')->textInput() ?>
<?= $form->field($model, 'const_data')->textarea(['rows' => 6]) ?>
