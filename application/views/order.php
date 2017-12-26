<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "确认订单";
?>

<div class="ui-form ui-border-t mb-20 mt-20">
    <div class="ui-form-item ui-border-b">
        <label>就诊人</label>
        <div class="ui-select">
            <select>
                <option>杨豪，男，29岁</option>
                <option>杨豪，男，29岁</option>
            </select>
        </div>
    </div>
</div>

<div class="ui-form ui-border-t mb-20">
    <div class="ui-form-item ui-border-b">
        <label>医生姓名</label>
        <input type="text" value="许润三" readonly>
    </div>

    <div class="ui-form-item ui-border-b">
        <label>就诊医院</label>
        <input type="text" value="汉典中医院" readonly>
    </div>

    <div class="ui-form-item ui-border-b">
        <label>就诊科室</label>
        <input type="text" value="妇科" readonly>
    </div>

    <div class="ui-form-item ui-border-b">
        <label>就诊地址</label>
        <input type="text" value="朝阳区石佛营东里133号" readonly>
    </div>

    <div class="ui-form-item ui-border-b">
        <label>预约时间</label>
        <input type="text" value="2017-12-25 (09:00-09:30)" readonly>
    </div>
</div>

<div class="ui-form ui-border-t mb-20">
    <div class="ui-form-item ui-border-b">
        <label>支付方式</label>
        <div class="ui-select">
            <select>
                <option>在线支付</option>
                <option>到院支付</option>
            </select>
        </div>
    </div>
</div>

<div class="ui-form ui-border-t mb-20">
    <div class="ui-form-item ui-border-b">
        <label>健康券</label>
        <div class="ui-select">
            <select>
                <option>无</option>
            </select>
        </div>
    </div>
</div>

<div class="ui-form ui-border-t mb-20">
    <div class="ui-form-item ui-border-b">
        <label>固币余额</label>
        <input type="text" value="0" readonly>
    </div>
</div>

<div class="ui-form ui-border-t mb-20">
    <div class="ui-form-item ui-border-b">
        <label>挂号金额</label>
        <input type="text" value="200" readonly>
    </div>
</div>

<div class="ui-container">
    <div class="ui-txt-info p-lr-15">
        预约前请认真阅读<a href="#">《预约需知》</a>
    </div>
</div>
