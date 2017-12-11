<?php

use common\extend\PanelGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WebsiteConfigGroup */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '配置分组';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
        Html::a('配置管理', ['@admin/website/config/list'], ['class' => 'btn btn-success']),
        Html::a('添加配置分组', ['@admin/website/group/create'], ['class' => 'btn btn-success']),
    ],
    //'filterModel'  => $searchModel,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'order',
        'created_at:datetime',
        ['class' => '\common\extend\ActionColumn'],
    ],
]); ?>
