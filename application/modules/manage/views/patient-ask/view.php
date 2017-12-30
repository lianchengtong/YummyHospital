<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PatientAsk */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Patient Asks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p class="text-right">
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
</p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            'user_id',
            'doctor_id',
            'patient_id',
            'description:ntext',
            'images:ntext',
            'reply:ntext',
            'reply_at',
            'created_at',
            'updated_at',
    ],
]) ?>

