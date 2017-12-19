<?php

use common\models\DoctorServiceTime;


/* @var $this yii\web\View */
/* @var $model common\models\DoctorServiceTime */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'week_service_start_at', ['inline' => true])
                 ->label("年")
                 ->dropDownList(DoctorServiceTime::numberRange(2017, 2039), [
                     'name'  => sprintf("%s[week_service_start_at][year]", $model->formName()),
                     'value' => $model->week_service_start_at['year'],
                 ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'week_service_start_at', ['inline' => true])
                 ->label("月")
                 ->dropDownList(DoctorServiceTime::numberRange(1, 12), [
                     'name'  => sprintf("%s[week_service_start_at][month]", $model->formName()),
                     'value' => $model->week_service_start_at['month'],
                 ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'week_service_start_at', ['inline' => true])
                 ->label("日")
                 ->dropDownList(DoctorServiceTime::numberRange(1, 31), [
                     'name'  => sprintf("%s[week_service_start_at][day]", $model->formName()),
                     'value' => $model->week_service_start_at['day'],
                 ]) ?>
    </div>
</div>

<?= $form->field($model, 'week', ['inline' => true])
         ->radioList(DoctorServiceTime::weekRange()) ?>

<?= $form->field($model, 'day', ['inline' => true])
         ->checkboxList(DoctorServiceTime::dayList("week"), [
             'name' => sprintf("%s[day][week][]", $model->formName()),
         ]) ?>

