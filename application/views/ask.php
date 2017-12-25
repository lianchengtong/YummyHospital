<?php

use yii\helpers\Html;

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "门诊预约";

$items = [
    '杨豪，男，27岁',
    '杨豪，男，28岁',
    '杨豪，男，29岁',
    '杨豪，男，29岁',
];
?>

<div class="row ui-form ui-border-t pb-20">
    <div class="ui-form-item ui-border-b">
        <label>就诊人</label>
        <div class="ui-select">
            <?= Html::dropDownList("patient", 0, $items) ?>
        </div>
    </div>

    <div class="ui-row-container mt-20 mb-20">
        <label class="ui-block">病情描述</label>
        <div class="ui-block-textarea-wrapper">
            <textarea rows="5" class="ui-block-textarea" placeholder="请对您的病情进行描述"></textarea>
        </div>
    </div>

    <div class="ui-row-container mt-20 mb-20">
        <?= \rogeecn\SimpleAjaxUploader\MultipleImage::widget([
            'style'             => false,
            'name'              => 'images',
            'value'             => "/upload/2017/12/25/62c75d38ad75151fb2863a1ca7d857fd.jpg,/upload/2017/12/25/62c75d38ad75151fb2863a1ca7d857fd.jpg",
            'uploadIconOptions' => [
                'class' => 'ui-icon-add',
            ],
        ]) ?>
        <p class="ui-txt-muted">
            请上传您的舌苔照、病历部位、病历、处方单、检查图片等诊断材料。
        </p>
    </div>
</div>

<div class="ui-btn-wrap mt-20">
    <button class="ui-btn-lg ui-btn-primary">确定</button>
</div>
