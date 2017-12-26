<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "用户登录";
?>

<div class="ui-register-login">
    <div class="ui-backdrop-filter"></div>

    <div class="form">
        <form action="">
            <h1 class="title">用户登录</h1>

            <div class="form-item">
                <label for="">手机号</label>
                <div class="input">
                    <input type="tel" pattern="\d" autocomplete="off"/>
                </div>
            </div>

            <div class="form-item">
                <label for="">密码</label>
                <div class="input">
                    <input type="password">
                </div>
            </div>

            <div class="form-item">
                <label for="">验证码</label>
                <div class="input ui-flex-input">
                    <input type="tel" pattern="\d*">
                    <div class="get-code">获取验证码</div>
                </div>
            </div>

            <div class="form-submit">
                <div class="input">
                    <input type="submit" value="注册" class="ui-btn-lg ui-btn-primary">
                </div>

                <ul class="ui-tiled  mt-20">
                    <li>
                        <div class="ui-full-width ui-align-left">
                            <a href="/register" class="ui-txt-white">还没有账号？快速注册</a>
                        </div>
                    </li>
                    <li>
                        <div class="ui-full-width ui-align-right">
                            <a href="#" class="ui-txt-white">使用短信验证码登录</a>
                        </div>
                    </li>
                </ul>
            </div>
        </form>
    </div>
</div>

