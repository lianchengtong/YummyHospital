<?php

/* @var $this yii\web\View */
/* @var $model common\models\WebsiteConfigGroup */
?>
<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'order')->textInput() ?>

