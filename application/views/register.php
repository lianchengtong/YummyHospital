<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\User */

$this->title = "用户注册";
?>

<div class="ui-register-login">
    <div class="ui-backdrop-filter"></div>

    <div class="form">
        <?php $form = \yii\widgets\ActiveForm::begin() ?>
        <h1 class="title">用户注册</h1>

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
        </div>

        <div class="form-item">
            <label for="">密码</label>
            <div class="input">
                <?= \yii\helpers\Html::activeTextInput($model, "password") ?>
            </div>
        </div>

        <div class="form-submit">
            <div class="input">
                <?= \yii\helpers\Html::submitButton("注册", [
                    'class' => 'ui-btn-lg ui-btn-primary',
                ]) ?>
            </div>
            <div class="ui-align-right mt-20">
                <a href="/login" class="ui-txt-white">已有账号？前往登录页面</a>
            </div>
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
            $.get("/sms/send", {phone: _phone, action: "register"}, function (data) {
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
