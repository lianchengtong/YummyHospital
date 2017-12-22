<?php

/** @var string $content */
/** @var \common\extend\View $this */
?>
<style>
</style>
<div class="weui-tab">
    <div class="weui-tab__panel">
        <div class="weui-navbar">
            <div class="" style="width: 40px">
                <?php if ($this->showGoBack): ?>
                    <div class="action_nav_goback weui-navbar__item" style="border:none">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="weui-navbar__item weui-navbar__item_no_border" style="border:none">
                <strong><?= $this->title ?></strong>
            </div>

            <div class="action_nav_save" style="width: 50px;">
                <?php if ($this->showNav): ?>
                    <div class="weui-navbar__item" style="border:none">
                        Save
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="weui-tab__panel">
            <?= $content; ?>
        </div>
    </div>
    <div class="weui-tabbar">
        <a href="javascript:;" class="weui-tabbar__item weui-bar__item_on">
                <span style="display: inline-block;position: relative;">
                    <img src="/images/icon_tabbar.png" alt="" class="weui-tabbar__icon">
                </span>
            <p class="weui-tabbar__label">微信</p>
        </a>

        <a href="javascript:;" class="weui-tabbar__item">
            <img src="/images/icon_tabbar.png" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label">通讯录</p>
        </a>

        <a href="javascript:;" class="weui-tabbar__item">
                <span style="display: inline-block;position: relative;">
                    <img src="/images/icon_tabbar.png" alt="" class="weui-tabbar__icon">
                </span>
            <p class="weui-tabbar__label">发现</p>
        </a>

        <a href="javascript:;" class="weui-tabbar__item">
            <img src="/images/icon_tabbar.png" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label">我</p>
        </a>
    </div>
</div>
