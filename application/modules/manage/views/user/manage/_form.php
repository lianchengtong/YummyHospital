<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */
?>



<?= $form->field($model, 'phone')->textInput(['maxlength' => TRUE]) ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => TRUE]) ?>

<?= $form->field($model, 'nickname')->textInput(['maxlength' => TRUE]) ?>

<?= $form->field($model, 'auth_key')->textInput(['maxlength' => TRUE]) ?>

<?= $form->field($model, 'password_hash')->textInput(['maxlength' => TRUE]) ?>

<?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => TRUE]) ?>

<?= $form->field($model, 'status')->textInput() ?>


