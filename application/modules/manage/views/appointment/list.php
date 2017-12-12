<?php

use common\extend\PanelGridView;
use common\models\DoctorAppointment;
use common\models\DoctorAppointmentTrack;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $isRecent boolean */
/* @var $searchModel common\models\search\DoctorAppointment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = $isRecent ? "近期预约" : "所有预约";
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
        Html::a('创建', ['create'], ['class' => 'btn btn-success']),
    ],
    'filterModel'  => $searchModel,
    'columns'      => [
        [
            'attribute' => 'user_id',
            'value'     => function ($model) {
                return $model->user->nickname;
            },
        ],
        [
            'attribute' => 'doctor_id',
            'value'     => function ($model) {
                return $model->doctor->name;
            },
        ],
        'time_begin:datetime',
        'time_end:datetime',
        'order_number',
        [
            'attribute' => 'status',
            'filter'    => DoctorAppointment::getStatus(),
            'value'     => function ($model) {
                return DoctorAppointment::getStatusDesc($model->status);
            },
        ],
        [
            'label'  => '跟踪',
            'format' => 'raw',
            'value'  => function ($model) {
                $link = ["@admin/appointment-track/list", 'id' => $model->id];
                $name = sprintf("跟踪记录 (%d)", DoctorAppointmentTrack::getCount($model->id));

                return Html::a($name, $link, ['class' => 'btn btn-info btn-xs']);
            },
        ],
        'created_at:datetime',
//        'updated_at:datetime',

        [
            'class'      => '\common\extend\ActionColumn',
            'showDelete' => FALSE,
        ],
    ],
]); ?>
