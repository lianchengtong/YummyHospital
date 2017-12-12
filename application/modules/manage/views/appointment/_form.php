<?php
use common\models\Doctor;
use common\models\DoctorAppointment;

/* @var $this yii\web\View */
/* @var $model common\models\DoctorAppointment */
/* @var $patientModel common\models\DoctorAppointmentPatientInfo */
?>
<?= $form->errorSummary($model) ?>
<?= $form->field($model, 'doctor_id')->dropDownList(Doctor::getList()) ?>
<?= $form->field($model, 'time_begin')->textInput() ?>
<?= $form->field($model, 'time_end')->textInput() ?>
<?= $form->field($model, 'order_number')->textInput() ?>
<?= $form->field($model, 'status')->dropDownList(DoctorAppointment::getStatus()) ?>

<div class="panel panel-default">
    <div class="panel-heading"><strong>患者信息</strong></div>
    <div class="panel-body">
        <?= $form->field($patientModel, 'username')->textInput() ?>
        <?= $form->field($patientModel, 'phone')->textInput() ?>
        <?= $form->field($patientModel, 'memo')->textarea() ?>
    </div>
</div>
