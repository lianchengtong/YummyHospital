<?php

use yii\helpers\Html;
use common\extend\PanelGridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\Order */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= PanelGridView::widget([
        'dataProvider' => $dataProvider,
        'buttons'      => [
            Html::a('创建', ['create'], ['class' => 'btn btn-success']),
        ],
         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'order_id',
            'out_trade_id',
            'channel',
            'name',
            // 'price',
            // 'status',
            // 'complete_at',
            // 'created_at',
            // 'updated_at',

            ['class' => '\common\extend\ActionColumn'],
        ],
    ]); ?>
