<?php

use common\extend\PanelGridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DoctorAppointmentTrack */
/* @var $model common\models\DoctorAppointmentTrack */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '预约跟踪反馈';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>添加反馈</strong>
    </div>
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'form'  => $form,
        ]) ?>
    </div>
    <div class="panel-footer text-right">
        <?= Html::submitButton("提交", ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'user_id',
            'value'     => function ($model) {
                return $model->user->nickname;
            },
        ],
        'track_message',
        'created_at:datetime',
    ],
]); ?>
