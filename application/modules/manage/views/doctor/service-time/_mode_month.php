<?php

use common\models\DoctorServiceTime;


/* @var $this yii\web\View */
/* @var $model common\models\DoctorServiceTime */
/* @var $form yii\widgets\ActiveForm */

?>
<?= $form->field($model, 'month', ['inline' => true])->checkboxList(DoctorServiceTime::monthList()) ?>
<?= $form->field($model, 'day', ['inline' => true])->checkboxList(DoctorServiceTime::dayList("month"), ['name' => 'day[month]']) ?>

