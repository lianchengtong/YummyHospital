<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\Order */

$this->title      = "你好中国";
$this->showGoBack = true;
$this->showTab    = false;
?>

<section class="ui-notice ui-pay-order">
    <i></i>
    <p class="title">恭喜您，预约成功！</p>

    <p><?= $model->name ?></p>

    <p class="price">订单金额：<?= $model->getPriceYuan() ?></p>

    <div class="ui-notice-btn">
        <button class="ui-btn-primary ui-btn-lg" disabled id="action-btn-pay">立即支付</button>
    </div>
</section>

<script>
    function onBridgeReady() {
        alert("ready");
        $("#action-btn-pay").removeAttr("disabled");
    }

    if (typeof WeixinJSBridge == "undefined") {
        if (document.addEventListener) {
            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
        } else if (document.attachEvent) {
            document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
            document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
        }
    } else {
        onBridgeReady();
    }

    $(function () {
        $("body").on("click", "#action-btn-pay", function () {
            $.get("/order/pay-info", {id: "<?=$model->order_id?>"}, function (data) {
                if (data.code != 0) {
                    alert("支付信息拉取失败,请重新支付！");
                    return false;
                }

                WeixinJSBridge.invoke(
                    'getBrandWCPayRequest',
                    data.data,
                    function (res) {
                        if (res.err_msg == "get_brand_wcpay_request:ok") {
                            location.href = "/order/list";
                        } else {
                            alert("支付失败， 请重新支付！");
                        }
                    }
                );
            })
        });
    })
</script>