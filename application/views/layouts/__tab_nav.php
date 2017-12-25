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

<header class="ui-header ui-header-stable ui-navbar ui-border-b">
    <?php if ($this->showGoBack): ?>
        <i class="ui-icon-return" onclick="history.back()"></i>
    <?php endif; ?>
    <h1>
        我是标题
    </h1>
    <?php if ($this->showSave): ?>
        <button class="ui-btn">Save</button>
    <?php endif; ?>
</header>


<footer class="ui-footer ui-footer-stable  ui-border-t">
    <ul class="ui-tiled">
        <?php foreach ($tabs as $tabItem): ?>
            <li>
                <a class="tab-item" href="<?= Url::to($tabItem['url']) ?>">
                    <div class="icon">
                        <?= Html::img($tabItem['icon']) ?>
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
