<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DoctorAppointmentTrack */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Doctor Appointment Tracks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p class="text-right">
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
</p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'user_id',
        'appointment_id',
        'track_message',
        'created_at',
        'updated_at',
    ],
]) ?>

