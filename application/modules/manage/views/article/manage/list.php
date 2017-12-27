<?php

use common\models\Category;
use common\models\ArticleType;
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
    'filterModel'  => $searchModel,
    'columns'      => [
        [
            'attribute' => 'type',
            'filter' => ArticleType::getList(),
            'value'     => function ($model) {
                return ArticleType::getByID($model->type)->name;
            },
        ],
        'title',
        'slug',
        [
            'attribute' => 'category',
            'filter' => Category::getFlatIndentList(true),
            'value'     => function ($model) {
                return Category::getName($model->category);
            },
        ],
        [
            'attribute' => 'author_id',
        ],
        'created_at:datetime',
        'updated_at:datetime',

        ['class' => '\common\extend\ActionColumn'],
    ],
]); ?>
