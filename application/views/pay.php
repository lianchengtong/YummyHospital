<?php

/** @var $this \common\extend\View */
$this->showTab = false;
?>

<footer class="ui-footer ui-footer-stable ui-pay-order-footer">
    <div class="price">总计: <span class="price-show">&yen;200</span></div>
    <div class="pay-btn">支付</div>
</footer>

<section class="ui-container pb-10 ui-pay-order">
    <div class="ui-form ui-border-t mt-20">
        <div class="ui-form-item ui-form-item-show ui-border-b">
            <label for="#">优惠券</label>
            <input type="text" value="" placeholder="请输入优惠券码">
        </div>
    </div>

    <div class="ui-form ui-border-t mt-20">
        <div class="ui-form-item ui-form-item-switch ui-border-b">
            <p>
                使用 100 积分抵换 1 元
            </p>
            <label class="ui-switch">
                <input type="checkbox" checked>
            </label>
        </div>
    </div>

    <ul class="ui-list ui-list-link ui-border-tb mt-20">
        <li class="select">
            <div class="ui-avatar">
                <span style="background-image:url(http://placeholder.qiniudn.com/100x100)"></span>
            </div>
            <div class="ui-list-info ui-border-t">
                <h4 class="ui-nowrap">会员卡</h4>
            </div>
        </li>
        <li>
            <div class="ui-avatar">
                <span style="background-image:url(http://placeholder.qiniudn.com/100x100)"></span>
            </div>
            <div class="ui-list-info ui-border-t">
                <h4 class="ui-nowrap">支付宝</h4>
            </div>
        </li>
        <li>
            <div class="ui-avatar">
                <span style="background-image:url(http://placeholder.qiniudn.com/100x100)"></span>
            </div>
            <div class="ui-list-info ui-border-t">
                <h4 class="ui-nowrap">微信支付</h4>
            </div>
        </li>
    </ul>

</section>
