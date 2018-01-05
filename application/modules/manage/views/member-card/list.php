<?php

use yii\helpers\Html;
use common\extend\PanelGridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MemberCard */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员卡';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php ActiveForm::begin(); ?>
<?= PanelGridView::widget([
    'dataProvider' => $dataProvider,
    'buttons'      => [
        Html::submitButton("提交排序", ['class' => 'btn btn-primary']),
        Html::a('创建', ['create'], ['class' => 'btn btn-success']),
    ],
    //         'filterModel' => $searchModel,
    'columns'      => [
        'name',
        'price',
        'discount',
        'pay_discount',
        'description:ntext',
        'time_long',
        [
            'attribute' => 'order',
            'format'    => 'raw',
            'options'   => [
                'style' => 'width: 80px;',
            ],
            'value'     => function ($data) {
                $name = sprintf("order[%d]", $data['id']);
                $orderAttr = [
                    'data-old'     => $data['order'],
                    'data-id'      => $data['id'],
                    'autocomplete' => 'off',
                    'name'         => sprintf("order[%d]", $data['id']),
                    'class'        => 'form-control input-sm',
                ];

                return Html::textInput($name, $data['order'], $orderAttr);
            },
        ],
        'created_at',

        ['class' => '\common\extend\ActionColumn'],
    ],
]); ?>
<?php ActiveForm::end(); ?>
