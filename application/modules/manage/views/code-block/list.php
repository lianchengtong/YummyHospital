<?php

use common\extend\PanelGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CodeBlock */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Code Blocks';
$this->params['breadcrumbs'][] = $this->title;

\yii\bootstrap\ActiveForm::begin();
echo PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
        Html::submitButton("提交排序", ['class' => 'btn btn-primary']),
        Html::a('创建', ['create'], ['class' => 'btn btn-success']),
    ],
    'filterModel'  => $searchModel,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'slug',
        [
            'attribute' => 'code',
            'filter'    => false,
            'format'    => 'raw',
            'value'     => function ($model) {
                $url = ['@admin/code-block/view', 'id' => $model->id];
                return Html::a('查看代码', $url, [
                    'target' => 'blank',
                    'class'  => 'btn btn-success btn-xs',
                ]);
            },
        ],
        [
            'attribute' => 'order',
            'filter'    => false,
            'format'    => 'raw',
            'options'   => [
                'style' => 'width: 80px;',
            ],
            'value'     => function ($data) {
                $name      = sprintf("order[%d]", $data['id']);
                $orderAttr = [
                    'data-old'     => $data['order'],
                    'data-id'      => $data['id'],
                    'autocomplete' => 'off',
                    'name'         => sprintf("order[%d]", $data['id']),
                    'class'        => 'form-control input-sm',
                ];

                return Html::textInput($name, $data['order'], $orderAttr);
            },
        ],
        ['class' => '\common\extend\ActionColumn'],
    ],
]);
\yii\bootstrap\ActiveForm::end();
