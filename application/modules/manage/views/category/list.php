<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** @var $dataProvider \yii\data\ArrayDataProvider */

$this->title                   = '分类管理';
$this->params['breadcrumbs'][] = ['label' => '分类管理', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;

ActiveForm::begin();
$createBtn = Html::a('创建根分类', ['@admin/category/create', 'id' => 0], ['class' => 'btn btn-success']);


echo \common\extend\PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
        Html::submitButton("提交排序", ['class' => 'btn btn-primary']),
        $createBtn,
    ],
    'columns'      => [
//        'id',
//        'pid',
        'name',
        'alias',
        [
            'attribute' => 'order',
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
        [
            'label'   => '',
            'format'  => 'raw',
            'options' => [
                'style' => 'width:200px',
            ],
            'value'   => function ($data) {
                $edit = Html::a("编辑", ['@admin/category/update', 'id' => $data['id']], [
                    'class' => 'btn-sm',
                ]);

                $create = Html::a("添加子分类", ['@admin/category/create', 'id' => $data['id']], [
                    'icon'  => 'plus',
                    'class' => 'btn-sm',
                ]);

                $delete = Html::a("删除", ['@admin/category/delete', 'id' => $data['id']], [
                    'onclick' => 'return confirm("确认删除么,分类及子分类都会被同时删除？")',
                    'class'   => 'btn-danger btn-sm',
                ]);

                return $edit . $create . $delete;
            },
        ],
    ],
]);
ActiveForm::end();
