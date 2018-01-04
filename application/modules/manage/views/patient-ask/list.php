<?php

use common\extend\PanelGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PatientAsk */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '患者咨询列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
        Html::a('创建', ['create'], ['class' => 'btn btn-success']),
    ],
    //'filterModel'  => $searchModel,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        'user.nickname',
        'doctor.name',
        'patient.name',
        //'description:ntext',
        //'images:ntext',
        //'reply:ntext',
        'reply_at:datetime',
        'created_at:datetime',
        //'updated_at:datetime',
        [
            'label'  => '#',
            'format' => 'raw',
            'value'  => function ($model) {
                $url = ['reply', 'id' => $model->id];
                if (empty($model->reply_at)) {
                    return Html::a("回复", $url, [
                        'class' => 'btn btn-success btn-xs',
                    ]);
                }

                return Html::a("回复", $url, [
                    'class' => 'btn btn-warning btn-xs',
                ]);
            },
        ],
    ],
]); ?>
