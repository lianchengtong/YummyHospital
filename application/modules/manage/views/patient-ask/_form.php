<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PatientAsk */
?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'doctor_id')->textInput() ?>

    <?= $form->field($model, 'patient_id')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'images')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'reply')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'reply_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>


