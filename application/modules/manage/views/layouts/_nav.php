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
        ['label' => '发布', 'url' => ['@admin/article/manage/select']],
        ['label' => '文章', 'items' => [
            ['label' => '所有文章', 'url' => ['@admin/article/manage/list']],
            ['label' => '文章类型', 'url' => ['@admin/article/type/list']],
        ]],
        ['label' => '预约', 'items' => [
            ['label' => '近期', 'url' => ['@admin/appointment/recent']],
            ['label' => '所有', 'url' => ['@admin/appointment/all']],
        ]],
        ['label' => '医生管理', 'items' => [
            ['label' => '医生', 'url' => ['@admin/doctor/doctor/list']],
            ['label' => '职称', 'url' => ['@admin/doctor/level/list']],
        ]],
        ['label' => '链接', 'url' => ['@admin/link/group/list']],
        ['label' => '分类', 'url' => ['@admin/category/list']],
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
