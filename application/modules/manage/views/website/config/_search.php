<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\WebsiteConfig */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>

<?= $form->field($model, 'id') ?>

<?= $form->field($model, 'key') ?>

<?= $form->field($model, 'value') ?>

<?= $form->field($model, 'type') ?>

<?= $form->field($model, 'const_data') ?>

<?php // echo $form->field($model, 'group_id') ?>

<?php // echo $form->field($model, 'order') ?>

<?php // echo $form->field($model, 'created_at') ?>

<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
</div>

<?php ActiveForm::end(); ?>

