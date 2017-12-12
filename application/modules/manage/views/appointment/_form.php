<?php
use common\models\Doctor;
use common\models\DoctorAppointment;

/* @var $this yii\web\View */
/* @var $model common\models\DoctorAppointment */
?>
<?=$form->errorSummary($model)?>
<?= $form->field($model, 'doctor_id')->dropDownList(Doctor::getList()) ?>
<?= $form->field($model, 'time_begin')->textInput() ?>
<?= $form->field($model, 'time_end')->textInput() ?>
<?= $form->field($model, 'order_number')->textInput() ?>
<?= $form->field($model, 'status')->dropDownList(DoctorAppointment::getStatus()) ?>
