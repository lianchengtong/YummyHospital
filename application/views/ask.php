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


<div class="weui-cells">
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">就诊人</label>
        </div>
        <div class="weui-cell__bd">
            <?= Html::dropDownList("patient", 0, $items, ['class' => 'weui-select']) ?>
        </div>
    </div>
</div>


<div class="weui-cells__title">病情描述</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <textarea class="weui-textarea" placeholder="请输入描述信息" rows="3"></textarea>
    </div>
</div>

<div class="weui-cell">
    <div class="weui-cell__bd">
        <div class="weui-uploader">
            <div class="weui-uploader__hd">
                <p class="weui-uploader__title">图片上传</p>
            </div>
            <?= \rogeecn\SimpleAjaxUploader\MultipleImage::widget([
                'name'  => '123',
                'value' => '',
            ]) ?>
            <ul class="weui-uploader__files" id="uploaderFiles">
                <li class="weui-uploader__file" style="background-image:url(./images/pic_160.png)"></li>
                <li class="weui-uploader__file" style="background-image:url(./images/pic_160.png)"></li>
                <li class="weui-uploader__file" style="background-image:url(./images/pic_160.png)"></li>
                <li class="weui-uploader__file weui-uploader__file_status"
                    style="background-image:url(./images/pic_160.png)">
                    <div class="weui-uploader__file-content">
                        <i class="weui-icon-warn"></i>
                    </div>
                </li>
                <li class="weui-uploader__file weui-uploader__file_status"
                    style="background-image:url(./images/pic_160.png)">
                    <div class="weui-uploader__file-content">50%</div>
                </li>
            </ul>
            <div class="weui-uploader__input-box">
                <input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/*" multiple/>
            </div>
        </div>
    </div>
</div>

<div class="weui-btn-area">
    <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">确定</a>
</div>
