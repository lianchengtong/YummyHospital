<?php

use common\extend\PanelGridView;
use common\models\WebsiteConfig;
use common\models\WebsiteConfigGroup;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WebsiteConfig */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '配置管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
        Html::a('新建配置项', ['@admin/website/config/create'], ['class' => 'btn btn-success']),
        Html::a('配置分组', ['@admin/website/group/list'], ['class' => 'btn btn-success']),
        Html::a('添加配置分组', ['@admin/website/group/create'], ['class' => 'btn btn-success']),
    ],
    'filterModel'  => $searchModel,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'group_id',
            'filter'    => WebsiteConfigGroup::getGroupList(),
            'value'     => function ($model) {
                return WebsiteConfigGroup::getNameByID($model->group_id);
            },
        ],
        [
            'attribute' => 'type',
            'filter'    => WebsiteConfig::getTypeList(),
            'value'     => function ($model) {
                return WebsiteConfig::getTypeName($model->type);
            },
        ],
        'key',
        'name',
        'hint',
        'const_data',
        ['class' => '\common\extend\ActionColumn'],
    ],
]); ?>
