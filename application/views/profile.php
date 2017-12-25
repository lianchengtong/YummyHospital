<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title    = "个人资料";
$this->showSave = true;
?>

<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">真实姓名</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" name="name"/>
        </div>
    </div>

    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">性别</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="sex">
                <option value="1">男</option>
                <option value="0">女</option>
            </select>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">手机号</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder="请输入手机号"/>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">成员关系</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" value="本人"/>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label for="" class="weui-label">生日</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="date" value="" placeholder=""/>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">身份证号</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder=""/>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">身高</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder=""/>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">体重</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder=""/>
        </div>
    </div>
</div>
