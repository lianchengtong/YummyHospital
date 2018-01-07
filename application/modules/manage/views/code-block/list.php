<?php

use common\extend\PanelGridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CodeBlock */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '代码段';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-xs-4">

        <?php
        \yii\bootstrap\ActiveForm::begin();
        echo PanelGridView::widget([
            'dataProvider' => $dataProvider,
            'buttons'      => [
                Html::submitButton("提交排序", ['class' => 'btn btn-primary']),
                Html::a('创建', ['create'], ['class' => 'btn btn-success']),
            ],
            //    'filterModel'  => $searchModel,
            'columns'      => [
                [
                    'label'  => '名称',
                    'format' => 'raw',
                    'value'  => function ($model) {
                        $html = Html::tag("strong", $model->name);
                        $html .= Html::tag("p", $model->slug);
                        return $html;
                    },
                ],
                [
                    'attribute' => 'order',
                    'filter'    => false,
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
                [
                    'class'    => '\common\extend\ActionColumn',
                ],
            ],
        ]);
        \yii\bootstrap\ActiveForm::end();
        ?>
    </div>
    <div class="col-xs-8" id="code-container"></div>
</div>

<script>
    $(function () {
        $("body").on("click", ".update-btn", function (e) {
            e.preventDefault();

            var url = $(this).attr("href");
            $.get(url, function (data) {
                $("#code-container").html(data);
            });
        });
    })
</script>
