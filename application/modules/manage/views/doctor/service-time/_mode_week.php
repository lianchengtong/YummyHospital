<?php

use common\models\DoctorServiceTime;


/* @var $this yii\web\View */
/* @var $model common\models\DoctorServiceTime */
/* @var $form yii\widgets\ActiveForm */

?>
<?= $form->field($model, 'week', ['inline' => true])
         ->radioList(DoctorServiceTime::weekRange()) ?>

<?= $form->field($model, 'day', ['inline' => true])
         ->checkboxList(DoctorServiceTime::dayList("week"), [
             'name' => sprintf("%s[day][week][]", $model->formName()),
         ]) ?>

