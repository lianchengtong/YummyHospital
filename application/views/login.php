<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "用户登录";
?>

<div class="ui-register-login">
    <div class="ui-backdrop-filter"></div>

    <div class="form">
        <?php $form = \yii\widgets\ActiveForm::begin() ?>
        <h1 class="title">用户登录</h1>

        <div class="form-item">
            <label for="">手机号</label>
            <div class="input">
                <?= \yii\helpers\Html::activeTextInput($model, "phone", [
                    'autocomplete' => 'off',
                    'type'         => 'tel',
                    'pattern'      => '\d*',
                    'id'           => 'phone',
                ]) ?>
            </div>
        </div>

        <div class="form-item">
            <?php if ($mode == "password") { ?>
                <label for="">密码</label>
                <div class="input">
                    <?= \yii\helpers\Html::activeTextInput($model, "password") ?>
                </div>
            <?php } else { ?>
                <label for="">验证码</label>
                <div class="input ui-flex-input">
                    <?= \yii\helpers\Html::activeTextInput($model, "code", [
                        'autocomplete' => 'off',
                        'type'         => 'tel',
                        'pattern'      => '\d{6}',
                        'id'           => 'code',
                    ]) ?>
                    <button class="get-code" id="action-btn-get-code">获取验证码</button>
                </div>
            <?php } ?>
        </div>

        <div class="form-submit">
            <div class="input">
                <?= \yii\helpers\Html::submitButton("登录", [
                    'class' => 'ui-btn-lg ui-btn-primary',
                ]) ?>
            </div>

            <ul class="ui-tiled  mt-20">
                <li>
                    <div class="ui-full-width ui-align-left">
                        <a href="/register" class="ui-txt-white">还没有账号？快速注册</a>
                    </div>
                </li>
                <li>
                    <div class="ui-full-width ui-align-right">
                        <?php
                        if ($mode == "password") {
                            echo \yii\helpers\Html::a("短信验证码登录", ['/login', 'mode' => 'code'], [
                                'class' => 'ui-txt-white',
                                'id'    => 'action-login-by-code',
                            ]);
                        } else {
                            echo \yii\helpers\Html::a("使用密码登陆", ['/login', 'mode' => 'password'], [
                                'class' => 'ui-txt-white',
                                'id'    => 'action-login-by-code',
                            ]);
                        }
                        ?>
                    </div>
                </li>
            </ul>
        </div>
        <?php \yii\widgets\ActiveForm::end() ?>
    </div>
</div>

<script>
    function delayCodeSend() {
        $("#action-btn-get-code").attr("disabled", true);

        var timeDelay = 60;
        var _timer = setInterval(function () {
            $("#action-btn-get-code").html(timeDelay-- + " 秒后重新获取");
        }, 1000);

        setTimeout(function () {
            $("#action-btn-get-code").removeAttr("disabled");
            $("#action-btn-get-code").html("获取验证码");
            clearInterval(_timer);
        }, timeDelay * 1000);
    }

    $(function () {
        $("body").on("click", "#action-btn-get-code", function (e) {
            e.preventDefault();

            var _phone = $("#phone").val();
            $.get("/sms/send", {phone: _phone, action: "login"}, function (data) {
                if (data.code != 0) {
                    alert(data.data);
                    return false;
                }

                alert("验证码已发送");
                delayCodeSend();
            });
        });
    })

    <?php
    if (!empty($errors)) {
        echo "alert(\"" . implode("\n", $errors) . "\");";
    }
    ?>
</script>
