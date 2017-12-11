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

$rightMenus = [
    ['label' => '首页', 'url' => ['/']],
];

if (\common\utils\UserSession::isGuest()) {
    $rightMenus[] = ['label' => '登录', 'url' => ['/manage/login']];
} else {
    $rightMenus[] = ['label' => '用户管理', 'url' => ['/manage/user/manage/list']];
    $rightMenus[] = ['label' => '退出', 'url' => ['/manage/logout']];
}

//echo \yii\bootstrap\Nav::widget([
//    'options' => ['class' => 'navbar-nav'],
//    'items'   => $leftMenus,
//]);

echo \yii\bootstrap\Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items'   => $rightMenus,
]);

\yii\bootstrap\NavBar::end();
