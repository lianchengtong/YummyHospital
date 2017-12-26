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
        'label' => '医生详情',
        'url'   => ['/doctor'],
    ],
    [
        'label' => '就诊人',
        'url'   => ['/patient'],
    ],
    [
        'label' => '确认订单',
        'url'   => ['/order'],
    ],
    [
        'label' => '添加、编辑就诊人',
        'url'   => ['/patient-form'],
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
</ul>
<div class="ui-my-patient-list">
    <div class="list-wrapper mb-20">
        <?php foreach ($items as $item): ?>
            <div class="ui-form-item ui-form-item-link ui-border-b">
                <?= Html::a($item['label'], $item['url']); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
