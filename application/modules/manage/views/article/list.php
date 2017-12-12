<?php

use common\extend\PanelGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\Article */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '文章列表';
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
        'id',
        'title',
        'slug',
        'head_image',
        'category',
        'keyword',
        'description',
        'author_id',
        'created_at:datetime',
        'updated_at:datetime',

        ['class' => '\common\extend\ActionColumn'],
    ],
]); ?>
