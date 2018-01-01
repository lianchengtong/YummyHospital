<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $models \common\models\DoctorAppointment[] */

$this->title = "我的预约";
?>
<div class="ui-appointment-list mt-20">
    <?php foreach ($models as $model): ?>
        <div class="ui-panel mb-20">
            <div class="ui-panel-body">
                <div class="patient-info">
                    <div class="ui-align-left">
                        <?= $model->patientInfo->name ?>
                    </div>
                    <div class="ui-align-right">
                        <?= "就诊日期：" . date("Y年m月d日", $model->time_begin); ?>
                        <?= "周" . \common\models\DoctorServiceTime::convertToWeekDay([date("N", $model->time_begin)])[0]; ?>
                    </div>
                </div>
                <div class="doctor-info">
                    <div class="head">
                        <?= \yii\helpers\Html::img($model->doctor->head_image) ?>
                    </div>
                    <div class="info">
                        <span class="name"><?= $model->doctor->name ?></span>
                        <span class="ui-txt-info"><?= $model->doctor->levelModel->level_name ?></span>
                    </div>
                </div>

                <div class="extend">
                    <span class="price">
                        诊费：<span class="ui-txt-warning">&yen;<?= $model->getPrice() ?></span>
                    </span>
                    <div class="buttons">
                        <?php
                        $statusOK      = $model->status == \common\models\DoctorAppointment::STATUS_COMPLETE;
                        $feedbackModel = $model->feedback;
                        if ($statusOK && !$feedbackModel) {
                            echo \yii\helpers\Html::a('立即评价', ["/appointment/feedback", "id" => $model->id], ['class' => 'ui-btn']);
                        }
                        if ($feedbackModel) {
                            echo "已评价";
                        }
                        ?>
                        <?php
                        $orderModel = $model->getOrderModel();
                        if ($orderModel && $orderModel->status == \common\models\Order::STATUS_PENDING_PAY) {
                            $payLink = ["/order/wechat-pay", 'id' => $orderModel->order_id];
                            echo \yii\helpers\Html::a("立即支付", $payLink, [
                                'class' => 'ui-btn ui-btn-primary',
                            ]);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
