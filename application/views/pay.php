<?php

/** @var $model \common\models\Order */
/** @var $this \common\extend\View */

$this->showTab = false;
$enableCard    = 1;
$enableCoin    = 1;
$enableCode    = 1;

$userCoin  = \common\utils\UserSession::getCoin();
$coinRate  = \common\models\WebsiteConfig::getValueByKey("global.coin-rate");
$coinMoney = $userCoin * $coinRate;

$userCard     = \common\models\MemberOwnCard::getUserEnableCard(\common\utils\UserSession::getId());
$discountRate = 0;
if ($userCard) {
    $discountRate = 1 - $userCard->discount / 100;
}
?>

<footer class="ui-footer ui-footer-stable ui-pay-order-footer">
    <div class="price">总计: <span class="price-show"><?= $model->getPriceYuan() ?></span></div>
    <div class="pay-btn">支付</div>
</footer>

<section class="ui-container pb-10 ui-pay-order">
    <?php if ($enableCode): ?>
        <div class="ui-form ui-border-t mt-20">
            <div class="ui-form-item ui-form-item-show ui-border-b">
                <label for="#">优惠券</label>
                <input type="text" value="" id="code" placeholder="请输入优惠券码">
            </div>
        </div>
        <p id="code-info-show" class="ui-txt-info pl-15 ui-hide">优惠券抵扣 <span></span> 元</p>
    <?php endif; ?>

    <?php if ($enableCoin): ?>
        <div class="ui-form ui-border-t mt-20">
            <div class="ui-form-item ui-form-item-switch ui-border-b">
                <p>使用 <?= $userCoin ?> 积分抵换 <?= $coinMoney ?> 元</p>
                <label class="ui-switch">
                    <input type="checkbox" id="coin">
                </label>
            </div>
        </div>
    <?php endif; ?>

    <ul class="ui-list ui-list-link ui-border-tb mt-20 pay-method-list">
        <?php
        $payChannel = \common\models\LinkGroup::getLinkItems("pay-channel");
        foreach ($payChannel as $channel):
            if ($channel->slug == "card") {
                if (!$enableCard || !$userCard) {
                    continue;
                }
            }
            ?>
            <li data-name="<?= $channel->slug ?>">
                <div class="ui-avatar">
                    <span style="background-image:url(http://placeholder.qiniudn.com/100x100)"></span>
                </div>
                <div class="ui-list-info ui-border-t">
                    <h4 class="ui-nowrap">
                        <?= $channel->name ?>
                        <?php
                        if ($channel->slug == "card") {
                            echo \yii\helpers\Html::tag("span", "余额：" . $userCard->remain_money, [
                                'class' => 'ui-txt-info',
                            ]);
                        }
                        ?>
                    </h4>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<?php
$form = \yii\widgets\ActiveForm::begin(['options' => ['id' => 'form']]);
echo \yii\helpers\Html::hiddenInput("data[code]", "", ['id' => "form-code"]);
echo \yii\helpers\Html::hiddenInput("data[coin]", 0, ['id' => "form-coin"]);
echo \yii\helpers\Html::hiddenInput("data[channel]", "", ['id' => "form-channel"]);
\yii\widgets\ActiveForm::end();
?>

<script>
    var orderPrice =<?=$model->getPriceYuan()?>;
    var coinMoney = <?=$coinMoney?>;
    var discountRate = <?=$discountRate?>;
    var minusPrice = {
        code: 0,
        coin: 0,
        discount: 0
    };

    function setPrice() {
        $(".price-show").text(orderPrice - minusPrice.code - minusPrice.coin - minusPrice.discount);
    }

    $(function () {
        $("body").on("change", "#coin", function () {
            var checked = $(this).is(":checked");
            if (checked) {
                minusPrice.coin = coinMoney;
                setPrice();

                $("#form-coin").val(1);
                return;
            }

            minusPrice.coin = 0;
            setPrice();

            $("#form-coin").val(0);
        });

        $("body").on("blur", "#code", function () {
            if ($(this).val().length == 0) {
                return;
            }
            var _code = $(this).val();
            $.get("/pay/code-info", {code: _code}, function (data) {
                if (data.code != 0) {
                    if (!$("#code-info-show").hasClass("ui-hide")) {
                        $("#code-info-show").addClass("ui-hide");
                    }

                    $("#code").val("");
                    $("#form-code").val("");
                    minusPrice.code = 0;
                    setPrice();
                    alert(data.data);
                    return;
                }

                $("#code-info-show span").text(data.data);
                $("#code-info-show").removeClass("ui-hide");
                $("#form-code").val(_code);

                minusPrice.code = data.data;
                setPrice();
            })
        });

        $("body").on("tap", ".pay-method-list li", function () {
            $(this).siblings().removeClass("select");
            $(this).addClass("select");

            var _name = $(this).attr("data-name");
            $("#form-channel").val(_name);

            if (_name == "card") {
                minusPrice.discount = orderPrice * discountRate;
                console.log(minusPrice.discount)
            } else {
                minusPrice.discount = 0;
            }
            setPrice();
        });

        $("body").on("tap", ".pay-btn", function () {
            if ($("#form-channel").val().length == 0) {
                alert("请选择支付方式");
                return;
            }
            $("#form").submit();
        });
    })
</script>
