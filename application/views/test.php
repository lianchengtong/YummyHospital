<?php

use yii\helpers\Html;

$items = [

    [
        'label' => '首页',
        'url'   => ['/'],
    ],
    [
        'label' => '在线问诊',
        'url'   => ['/ask'],
    ],
    [
        'label' => '在线预约',
        'url'   => ['/appointment'],
    ],
    [
        'label' => '医生列表',
        'url'   => ['/doctor'],
    ],
    [
        'label' => '我的预约',
        'url'   => ['/my-appointment'],
    ],
    [
        'label' => '个人资料',
        'url'   => ['/profile'],
    ],
    [
        'label' => '注册',
        'url'   => ['/register'],
    ],
    [
        'label' => '登录',
        'url'   => ['/login'],
    ],
];
?>
<ul>
    <?php foreach ($items as $item): ?>
        <li><?= Html::a($item['label'], $item['url']); ?></li>
    <?php endforeach; ?>
</ul>