<?php

use yii\helpers\Html;

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "就诊人管理";
?>

<div class="ui-my-patient-list">
    <?= \application\builder\Code::output("element.patient-list.alert") ?>

    <div class="list-wrapper mb-20">
        <?php foreach ($models as $model): ?>
            <div class="ui-form-item ui-form-item-link ui-border-b">
                <?= Html::a($model->name, ['/patient/update', 'id' => $model->id]) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="ui-btn-wrapper">
        <?= Html::a("添加新就诊人", ['/patient/create'], ['class' => 'ui-btn-lg ui-btn-add-new-patient']) ?>
    </div>

</div>