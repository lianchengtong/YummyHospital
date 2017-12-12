<?php

use common\extend\PanelGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\LinkGroup */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '链接分组';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'showHeader'   => FALSE,
    'buttons'      => [
        Html::a('创建', ['create'], ['class' => 'btn btn-success']),
    ],
//    'filterModel'  => $searchModel,
    'columns'      => [
        'name',
        'slug',
        [
            'label'         => 'LinkItem',
            'format'        => 'raw',
            'headerOptions' => [
                'width' => 120,
            ],
            'value'         => function ($model) {
                return Html::a("链接管理", ['@admin/link/item/list', 'group' => $model->id], [
                    'class' => 'btn btn-info btn-xs',
                ]);
            },
        ],

        ['class' => '\common\extend\ActionColumn'],
    ],
]); ?>
