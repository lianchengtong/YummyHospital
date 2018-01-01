<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $models \common\models\PatientFeedback[] */

$this->title = "我的评价";
?>

<div class="ui-appointment-feedback-list mt-20">
    <?php foreach ($models as $model): ?>
        <div class="ui-panel mb-20  pt-15 pb-15">
            <div class="ui-panel-body">
                <div class="patient-info">
                    <div class="ui-align-left">
                        <?= $model->appointment->patientInfo->name ?>
                    </div>
                    <div class="ui-align-right">
                        <?= "就诊日期：" . date("Y年m月d日", $model->appointment->time_begin); ?>
                    </div>
                </div>
                <div class="doctor-info">
                    <span class="name">就诊医生：<?= $model->doctor->name ?></span>
                    <span class="ui-txt-info"><?= $model->doctor->levelModel->level_name ?></span>
                </div>
                <div class="feedback-mark">
                    <?php
                    for ($i = 0; $i < $model->mark; $i++) {
                        echo \yii\helpers\Html::tag("i", "", [
                            'class' => 'ui-icon-star light',
                        ]);
                    }
                    for ($i = 0; $i < (5 - $model->mark); $i++) {
                        echo \yii\helpers\Html::tag("i", "", [
                            'class' => 'ui-icon-star',
                        ]);
                    }
                    ?>
                </div>
                <div class="feedback-content pt-15 pb-15">
                    <?= $model->content ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

