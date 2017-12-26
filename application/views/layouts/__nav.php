<?php

use yii\helpers\Html;
use yii\helpers\Url;

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

<section class="ui-container">
    <?= $content ?>
</section>
