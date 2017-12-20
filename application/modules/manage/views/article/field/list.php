<?php

use common\extend\PanelGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ArticleTypeField */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $typeModel \common\models\ArticleType */

$this->title                   = '字段管理：' . $typeModel->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
        Html::submitButton('保存排序', ['class' => 'btn btn-primary']),
        Html::a('创建', ['create', 'type' => $typeModel->id], ['class' => 'btn btn-success']),
    ],
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'description',
        'class',
        'configure',
        'side_show:boolean',
        [
            'attribute' => 'order',
            'format'    => 'raw',
            'value'     => function ($model) {
                $inputName = "order[" . $model->id . "]";
                $options   = [
                    'class' => 'form-control input-sm',
                ];
                return Html::textInput($inputName, $model->order, $options);
            },
        ],
        ['class' => '\common\extend\ActionColumn'],
    ],
]); ?>
