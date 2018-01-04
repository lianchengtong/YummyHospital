<?php

use common\extend\PanelGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ArticleType */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '文章类型列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php $form = \yii\bootstrap\ActiveForm::begin() ?>
<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
        Html::submitButton('保存排序', ['class' => 'btn btn-primary']),
        Html::a('创建', ['create'], ['class' => 'btn btn-success']),
    ],
    'columns'      => [
        'name',
        'slug',
        'description',
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
        [
            'attribute' => '#',
            'format'    => 'raw',
            'value'     => function ($model) {
                $options = [
                    'class' => 'btn btn-success btn-xs',
                ];
                return Html::a('字段管理', ['@admin/article/field/list', 'id' => $model->id], $options);
            },
        ],
        ['class' => '\common\extend\ActionColumn'],
    ],
]); ?>
<?php \yii\bootstrap\ActiveForm::end() ?>
