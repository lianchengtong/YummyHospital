<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var string $content */
/** @var \common\extend\View $this */

$tabs = [
    [
        'url'         => "javascript:;",
        'label'       => '首页',
        'icon'        => '/images/tab-0.png',
        'active_icon' => '/images/active-tab-0.png',
    ],
    [
        'url'         => "javascript:;",
        'label'       => '在线咨询',
        'icon'        => '/images/tab-1.png',
        'active_icon' => '/images/active-tab-1.png',
    ],
    [
        'url'         => "javascript:;",
        'label'       => '我的预约',
        'icon'        => '/images/tab-2.png',
        'active_icon' => '/images/active-tab-2.png',
    ],
    [
        'url'         => "javascript:;",
        'label'       => '个人中心',
        'active'      => true,
        'icon'        => '/images/tab-3.png',
        'active_icon' => '/images/active-tab-3.png',
    ],
];
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


<footer class="ui-footer ui-footer-stable ui-border-t ui-footer-tabbar">
    <ul class="ui-tiled">
        <?php foreach ($tabs as $tabItem): ?>
            <li class="tab-item <?= $tabItem['active'] ? "active" : '' ?>">
                <a href="<?= Url::to($tabItem['url']) ?>">
                    <div class="icon">
                        <?= Html::img($tabItem['active'] ? $tabItem['active_icon'] : $tabItem['icon']) ?>
                    </div>
                    <div class="label">
                        <p><?= $tabItem['label'] ?></p>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</footer>


<section class="ui-container">
    <?= $content ?>
</section>
