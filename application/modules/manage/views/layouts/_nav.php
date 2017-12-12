<?php
\yii\bootstrap\NavBar::begin([
    'brandLabel'            => "Hello World!",
    'brandUrl'              => ["@admin/dashboard"],
    'innerContainerOptions' => [
        'class' => 'container-fluid',
    ],
    'options'               => [
        'class' => 'navbar navbar-default navbar-static-top',
    ],
]);

$leftMenus  = [
];
$rightMenus = [
    ['label' => '首页', 'url' => ['/']],
];

if (\common\utils\UserSession::isGuest()) {
    $rightMenus[] = ['label' => '登录', 'url' => ['/manage/login']];
} else {
    $leftMenus    = [
        ['label' => '链接', 'url' => ['@admin/link/group/list']],
        ['label' => '分类', 'url' => ['@admin/category/list']],
        ['label' => '文章', 'url' => ['@admin/article/list']],
        ['label' => '用户', 'items' => [
            ['label' => '注册用户', 'url' => ['@admin/user/manage/list']],
            ['label' => '后台用户', 'url' => ['@admin/user/manage/admin-list']],
        ]],
        ['label' => '系统', 'items' => [
            ['label' => '系统配置', 'url' => ['@admin/website/config/set']],
            ['label' => '配置管理', 'url' => ['@admin/website/config/list']],
        ]],
    ];
    $rightMenus[] = ['label' => '退出', 'url' => ['/manage/logout']];
}

echo \yii\bootstrap\Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items'   => $leftMenus,
]);

echo \yii\bootstrap\Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items'   => $rightMenus,
]);

\yii\bootstrap\NavBar::end();
