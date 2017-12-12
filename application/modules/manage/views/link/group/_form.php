<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LinkGroup */
?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>


