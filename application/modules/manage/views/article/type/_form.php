<?php

/* @var $this yii\web\View */
/* @var $model common\models\ArticleType */
?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

<?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>

