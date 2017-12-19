<?php

use common\models\DoctorLevel;
use rogeecn\SimpleAjaxUploader\SingleImage;

/* @var $this yii\web\View */
/* @var $model common\models\Doctor */
?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, "head_image")->widget(SingleImage::className()); ?>
        <?= $form->field($model, 'level')->dropDownList(DoctorLevel::levelList()) ?>
        <?= $form->field($model, 'work_time')->textInput() ?>
        <?= $form->field($model, 'rank')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-9">
        <?= $form->field($model, 'summary')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'introduce')->textarea(['rows' => 6]) ?>
    </div>
</div>
