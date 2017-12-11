<?php

use yii\helpers\Html;
use common\extend\PanelGridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
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
            'phone',
            'email:email',
            'nickname',
            'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            // 'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
