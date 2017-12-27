<?php

use common\extend\PanelGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SmsHistory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Sms Histories';
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
        'phone',
        'success',
        'data:ntext',
        'created_at:datetime',
    ],
]); ?>
