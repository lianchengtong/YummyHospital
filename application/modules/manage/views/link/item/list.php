<?php

use common\extend\PanelGridView;
use common\models\LinkGroupItem;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\LinkGroupItem */
/* @var $linkGroupModel common\models\LinkGroup */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '链接列表：' . $linkGroupModel->name;
$this->params['breadcrumbs'][] = ['label' => '链接分组', 'url' => ['@admin/link/group/list']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php
\yii\widgets\ActiveForm::begin();
?>
<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
        Html::a('链接分组', ['@admin/link/group/list'], ['class' => 'btn btn-primary']),
        Html::submitButton("保存排序", ['class' => 'btn btn-primary']),
        Html::a('创建', ['create', 'group' => $linkGroupModel->id], ['class' => 'btn btn-success']),
    ],
    //'filterModel'  => $searchModel,
    'columns'      => [
        'name',
        'slug',
        [
            'attribute' => 'type',
            'filter'    => LinkGroupItem::typeList(),
            'value'     => function ($model) {
                return LinkGroupItem::getTypeDesc($model->type);
            },
        ],
        'pid',
        'data',
        'options',
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

        ['class' => '\common\extend\ActionColumn'],
    ],
]); ?>
<?php
\yii\widgets\ActiveForm::end();
?>
