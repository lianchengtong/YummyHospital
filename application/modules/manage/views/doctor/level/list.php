<?php

use common\extend\PanelGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DoctorLevel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '职称管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'showHeader'   => FALSE,
    'buttons'      => [
        Html::a('创建', ['create'], ['class' => 'btn btn-success']),
    ],
    'columns'      => [
        'level_name',
        ['class' => '\common\extend\ActionColumn'],
    ],
]); ?>
