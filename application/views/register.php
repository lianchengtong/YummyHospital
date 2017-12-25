<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "用户注册";
?>

<div class="register-login">
    <div class="img-container">
        <img src="/images/cat1.jpg">
    </div>

    <div class="form">
        <h1 class="title">用户注册</h1>
        <form action="">
            <div class="form-item">
                <label for="">手机号</label>
                <div class="input">
                    <input type="number" autocomplete="off"/>
                </div>
            </div>
            <div class="form-item">
                <label for="">密码</label>
                <div class="input">
                    <input type="password">
                </div>
            </div>

            <div class="form-item">
                <div class="input">
                    <input type="submit" value="登陆" class="submit">
                </div>
                <div class="input mt-20">
                    <a href="#" class="">已有账号</a>
                </div>
            </div>
        </form>
    </div>
</div>
