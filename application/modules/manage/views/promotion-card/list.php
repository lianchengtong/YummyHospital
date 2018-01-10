<?php

use common\extend\PanelGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PromotionCard */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Promotion Cards';
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
        'user.nickname',
        'card_number',
        'card_worth',
        'batch_code',
        'active_at:datetime',
        'created_at:datetime',
    ],
]); ?>
