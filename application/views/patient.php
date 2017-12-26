<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "就诊人";
?>

<div class="ui-my-patient-list">
    <div class="alert">
        <a class="ui-icon ui-icon-info-block"></a>每每个项目两侧的间隔相等。所以，项目之间的间隔比项目与边框的间隔大一倍。个项目两侧的
    </div>

    <div class="list-wrapper mb-20">
        <?php for ($i = 0; $i < 5; $i++): ?>
            <div class="ui-form-item ui-form-item-link ui-border-b">
                <a href="#">小红</a>
            </div>
        <?php endfor; ?>
    </div>

    <div class="ui-btn-wrapper">
        <button class="ui-btn-lg ui-btn-add-new-patient">
            添加新就诊人
        </button>
    </div>

</div>
