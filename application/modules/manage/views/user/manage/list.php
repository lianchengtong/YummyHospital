<?php

use common\extend\PanelGridView;
use yii\helpers\Html;

/* @var $isAdmin boolean */
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = $isAdmin ? '管理员列表' : '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
        Html::a('创建', ['create', 'admin' => $isAdmin], ['class' => 'btn btn-success']),
    ],
    'filterModel'  => $searchModel,
    'columns'      => [
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
