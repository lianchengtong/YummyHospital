<?php
use common\models\DoctorLevel;

/* @var $this yii\web\View */
/* @var $model common\models\Doctor */
?>

<?= $form->field($model, 'head_image')->textInput(['maxlength' => TRUE]) ?>

<?= $form->field($model, 'level')->dropDownList(DoctorLevel::levelList()) ?>

<?= $form->field($model, 'name')->textInput() ?>

<?= $form->field($model, 'summary')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'work_time')->textInput() ?>

<?= $form->field($model, 'introduce')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'rank')->textInput(['maxlength' => TRUE]) ?>
