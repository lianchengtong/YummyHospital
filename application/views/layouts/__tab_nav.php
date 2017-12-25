<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var string $content */
/** @var \common\extend\View $this */

$tabs = [
    [
        'url'   => "javascript:;",
        'label' => '首页',
        'icon'  => '/images/icon_tabbar.png',
    ],
    [
        'url'   => "javascript:;",
        'label' => '在线咨询',
        'icon'  => '/images/icon_tabbar.png',
    ],
    [
        'url'   => "javascript:;",
        'label' => '我的预约',
        'icon'  => '/images/icon_tabbar.png',
    ],
    [
        'url'   => "javascript:;",
        'label' => '个人中心',
        'icon'  => '/images/icon_tabbar.png',
    ],
];
?>
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
                <?php if ($this->showSave): ?>
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
        <?php foreach ($tabs as $tabItem): ?>
            <a href="<?= Url::to($tabItem['url']) ?>" class="weui-tabbar__item">
                <span style="display: inline-block;position: relative;">
                    <?= Html::img($tabItem['image'], ['class' => 'weui-tabbar__icon']) ?>
                </span>
                <p class="weui-tabbar__label"><?= $tabItem['label'] ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</div>
