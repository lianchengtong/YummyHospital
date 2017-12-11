<?php
\yii\bootstrap\NavBar::begin([
    'brandLabel'            => "Hello World!",
    'innerContainerOptions' => [
        'class' => 'container-fluid',
    ],
    'brandUrl'              => NULL,
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
        ['label' => '用户', 'items' => [
            ['label' => '注册用户', 'url' => ['/manage/user/manage/list']],
            ['label' => '后台用户', 'url' => ['/manage/user/manage/admin-list']],
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
