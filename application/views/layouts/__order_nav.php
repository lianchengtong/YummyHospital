<?php

/** @var string $content */
/** @var \common\extend\View $this */
?>

<header class="ui-header ui-header-stable ui-navbar ui-border-b">
    <?php if ($this->showGoBack): ?>
        <i class="ui-icon-return" onclick="history.back()"></i>
    <?php endif; ?>
    <h1><?= $this->title ?></h1>
    <?php if ($this->showSave): ?>
        <button class="ui-btn">Save</button>
    <?php endif; ?>
</header>


<footer class="ui-footer ui-footer-stable  ui-border-t ui-order-footer">
    <div class="tab-item ui-price-wrapper">
        <div class="ui-price-flex-wrapper">
            实付款: <span class="ui-txt-danger ui-price-show">&yen;200</span>
        </div>
    </div>
    <div class="tab-item ui-order-ensure action-order-ensure">确认订单</div>
</footer>


<section class="ui-container">
    <?= $content ?>
</section>
