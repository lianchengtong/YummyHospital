<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SmsHistory */
?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'success')->textInput() ?>

    <?= $form->field($model, 'data')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>


