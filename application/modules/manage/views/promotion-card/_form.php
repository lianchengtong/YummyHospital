<?php

/* @var $this yii\web\View */
/* @var $model common\models\PromotionCard */
?>
<?= $form->field($model, 'template')->textInput([
    'maxlength'   => true,
    'placeholder' => "如: {date}-{time}-{string:3}-{number:5}",
]) ?>
<?= $form->field($model, 'count')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'card_worth')->textInput() ?>
<?= $form->field($model, 'batch_code')->textInput(['maxlength' => true]) ?>
