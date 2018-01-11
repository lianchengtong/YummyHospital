<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\Order */

$this->title = "我的订单";
?>

<div class="ui-order-list">
    <?php foreach ($models as $model) { ?>
        <section class="ui-panel mt-20">
            <div class="ui-panel-heading">
                <div class="title">
                    <?= $model->name ?>
                </div>
                <div class="price">
                    <?= $model->getPriceYuan() ?>
                </div>
            </div>
            <div class="ui-panel-body">

            </div>
            <div class="ui-panel-body ui-align-right">
                <?php
                switch ($model->status) {
                    case \common\models\Order::STATUS_PENDING_PAY:
                        echo \yii\helpers\Html::a("取消订单", ['order/cancel-pay', 'id' => $model->order_id], [
                            'class' => 'ui-btn ui-btn-danger mr-10',
                        ]);
                        echo \yii\helpers\Html::a("立即支付", ['pay/index', 'id' => $model->order_id], [
                            'class' => 'ui-btn ui-btn-primary',
                        ]);
                        break;
                    case \common\models\Order::STATUS_PAY_CLOSED:
                        echo \yii\helpers\Html::tag("span", "已关闭");
                        break;
                    case \common\models\Order::STATUS_PAY_REFUND:
                        echo \yii\helpers\Html::tag("span", "已退款");
                        break;
                    case \common\models\Order::STATUS_PAY_SUCCESS:
                        echo \yii\helpers\Html::tag("span", "支付成功");
                        break;
                }
                ?>
            </div>
        </section>
    <?php } ?>
</div>
