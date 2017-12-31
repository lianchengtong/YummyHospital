<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $model \common\models\Doctor */

$this->title = "医生详情";
?>


<?= \application\builder\Code::output("element.doctor.bottom-buttons", [
    'model' => $model,
]) ?>


<section class="ui-container">
    <?= \application\builder\Code::output("element.doctor.head-info", ['model' => $model]) ?>
    <?= \application\builder\Code::output("element.doctor.patient-info", ['model' => $model]) ?>
    <?= \application\builder\Code::output("element.doctor.good-at", ['model' => $model]) ?>
    <?= \application\builder\Code::output("element.doctor.description", ['model' => $model]) ?>
    <?= \application\builder\Code::output("element.doctor.patient-feedback", ['model' => $model]) ?>
    <?= \application\builder\Code::output("element.doctor.same-department-doctor-recommend", ['model' => $model]) ?>
</section>



