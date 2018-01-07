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

$rightMenus = [
    ['label' => '首页', 'url' => ['/']],
];

if (\common\utils\UserSession::isGuest() || !\common\utils\UserSession::isAdmin()) {
    $rightMenus[] = ['label' => '登录', 'url' => ['/manage/login']];
} else {
    $leftMenus = [
        ['label' => '发布', 'url' => ['@admin/article/manage/select']],
        ['label' => '文章', 'items' => [
            ['label' => '所有文章', 'url' => ['@admin/article/manage/list']],
            ['label' => '文章类型', 'url' => ['@admin/article/type/list']],
        ]],
        ['label' => '预约', 'url' => ['@admin/appointment/all']],
        ['label' => '订单管理', 'url' => ['@admin/appointment/all']],
        ['label' => '会员卡', 'items' => [
            ['label' => '管理', 'url' => ['@admin/member-card/list']],
            ['label' => '已售', 'url' => ['@admin/member-own-card/list']],
        ]],
        ['label' => '在线咨询', 'url' => ['@admin/patient-ask/list']],
        ['label' => '医生管理', 'items' => [
            ['label' => '医生', 'url' => ['@admin/doctor/doctor/list']],
            ['label' => '科室', 'url' => ['@admin/department/list']],
            ['label' => '职称', 'url' => ['@admin/doctor/level/list']],
        ]],
        ['label' => '链接', 'url' => ['@admin/link/group/list']],
        ['label' => '分类', 'url' => ['@admin/category/list']],
        ['label' => '用户', 'items' => [
            ['label' => '注册用户', 'url' => ['@admin/user/manage/list']],
            ['label' => '后台用户', 'url' => ['@admin/user/manage/admin-list']],
        ]],
        ['label' => '系统', 'items' => [
            ['label' => '短信统计', 'url' => ['@admin/sms-history/list']],
            ['label' => '系统配置', 'url' => ['@admin/website/config/set']],
            ['label' => '代码块', 'url' => ['@admin/code-block/list']],
            ['label' => '配置管理', 'url' => ['@admin/website/config/list']],
            ['label' => '备份/恢复', 'url' => ['@admin/website/system']],
        ]],
        ['label' => '代码块', 'url' => ['@admin/code-block/list']],
    ];

    $rightMenus[] = ['label' => '清理缓存', 'url' => [
        '@admin/cache/clear',
        '__return' => $_SERVER['REQUEST_URI'],
    ]];
    $rightMenus[] = ['label' => '退出', 'url' => ['@admin/logout']];
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
