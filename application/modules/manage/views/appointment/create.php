<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DoctorAppointment */
/* @var $form yii\widgets\ActiveForm */

$this->title                   = '新建预约';
$this->params['breadcrumbs'][] = ['label' => 'Doctor Appointments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading">
    </div>
    <div class="panel-body">
        <?= $this->render('_form', [
            'model'        => $model,
            'patientModel' => $patientModel,
            'form'         => $form,
        ]) ?>
    </div>
    <div class="panel-footer text-right">
        <?= Html::submitButton("提交", ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
