<?php

use yii\helpers\Html;
use common\extend\PanelGridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MemberOwnCard */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '售出会员卡';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
//        Html::a('创建', ['create'], ['class' => 'btn btn-success']),
    ],
    'filterModel'  => $searchModel,
    'columns'      => [
        'user.nickname',
        'original_money',
        'remain_money',
        'discount',
        'expire_at:datetime',
        'created_at:datetime',
        [
            'class' => '\common\extend\ActionColumn',
            'template' => '{update}',
        ],
    ],
]); ?>
