<?php

use common\extend\PanelGridView;
use common\models\DoctorLevel;
use common\models\DoctorServiceTime;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\Doctor */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '所有医生';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
        Html::a('创建', ['create'], ['class' => 'btn btn-success']),
    ],
    'columns'      => [
        [
            'attribute' => 'head_image',
            'format'    => 'raw',
            'value'     => function ($model) {
                return Html::img($model->head_image, [
                    'height' => '100',
                ]);
            },
        ],
        'name',
        [
            'attribute' => 'department',
            'format'    => 'raw',
            'value'     => function ($model) {
                return implode(",", \common\models\DoctorDepartment::getDepartmentList($model->id));
            },
        ],
        [
            'attribute' => 'tag',
            'format'    => 'raw',
            'value'     => function ($model) {
                return implode(",", \common\models\DoctorTag::getList($model->id));
            },
        ],
        'doctorServiceTime.price',
        'doctorServiceTime.ticket_count',
        [
            'attribute' => 'level',
            'filter'    => DoctorLevel::levelList(),
            'value'     => function ($model) {
                return DoctorLevel::levelDesc($model->level);
            },
        ],
        'work_time',
        'rank',
        [
            'label'  => '会诊信息',
            'format' => 'raw',
            'value'  => function ($model) {
                $desc    = DoctorServiceTime::getDescription($model->id);
                $link    = ["@admin/doctor/service-time/manage", 'id' => $model->id];
                $editBtn = Html::a("编辑", $link, [
                    'class' => 'btn btn-info btn-xs',
                ]);

                return $desc . $editBtn;
            },
        ],
        [
            'label'  => '详细信息',
            'format' => 'raw',
            'value'  => function ($model) {
                $link = ["@admin/doctor/doctor/view", 'id' => $model->id];

                return Html::a("查看详情", $link, [
                    'class' => 'btn btn-info btn-xs',
                ]);
            },
        ],
        ['class' => '\common\extend\ActionColumn'],
    ],
]); ?>
