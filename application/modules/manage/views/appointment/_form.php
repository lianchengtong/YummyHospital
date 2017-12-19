<?php

use common\models\Doctor;
use common\models\DoctorAppointment;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\DoctorAppointment */
/* @var $patientModel common\models\DoctorAppointmentPatientInfo */

if (!$model->isNewRecord) {
    $model->time_begin = date("Y-m-d H:i", $model->time_begin);
    $model->time_end   = date("Y-m-d H:i", $model->time_end);
}
?>
<?= $form->field($model, 'doctor_id')->dropDownList(Doctor::getList()) ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'time_begin')->widget(DateTimePicker::className(), [
            'type'          => DateTimePicker::TYPE_INPUT,
            'readonly'      => true,
            'pluginOptions' => [
                'startDate' => date("Y-m-d"),
                'autoclose' => true,
                'format'    => 'yyyy-mm-dd hh:ii',
            ],
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'time_end')->widget(DateTimePicker::className(), [
            'type'          => DateTimePicker::TYPE_INPUT,
            'readonly'      => true,
            'pluginOptions' => [
                'startDate' => date("Y-m-d"),
                'autoclose' => true,
                'format'    => 'yyyy-mm-dd hh:ii',
            ],
        ]) ?>
    </div>
</div>

<?= $form->field($model, 'order_number')->textInput() ?>

<?= $form->field($model, 'status', ['inline' => true])->radioList(DoctorAppointment::getStatus()) ?>

<div class="panel panel-default">
    <div class="panel-heading"><strong>患者信息</strong></div>
    <div class="panel-body">
        <?= $form->field($patientModel, 'username')->textInput() ?>
        <?= $form->field($patientModel, 'phone')->textInput() ?>
        <?= $form->field($patientModel, 'memo')->textarea() ?>
    </div>
</div>
