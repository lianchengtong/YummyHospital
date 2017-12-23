<?php

use yii\helpers\Html;

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "门诊预约";

$doctorInfo = [
    'title'       => '许润三',
    'subTitle'    => '国家医生',
    'url'         => '#',
    'image'       => '/images/avatar.png',
    'favor'       => '由各种物质组成的巨型球状天体',
    'description' => '由各种物质组成的巨型球状天体，叫做星球。星球有一定的形状，有自己的运行轨道。',
];
$items      = array_pad([], 10, $doctorItem);
?>

<div class="doctor-banner">
    <div class="nav">
        <div class="action_nav_goback">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </div>
        <span>医生主页</span>
    </div>

    <div class="show">
        <div class="head-img">
            <?= Html::img("/images/avatar.png") ?>
        </div>
        <p class="info">
            徐润三&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;国医大师
        </p>
    </div>

    <div class="information">
        <div class="info-block">
            <span class="title">接诊量</span>
            <p class="count">15</p>
        </div>
        <div class="info-block">
            <span class="title">接诊量</span>
            <p class="count">15</p>
        </div>
        <div class="info-block">
            <span class="title">接诊量</span>
            <p class="count">15</p>
        </div>
        <div class="info-block">
            <span class="title">接诊量</span>
            <p class="count">15</p>
        </div>
    </div>
</div>

<div class="grid">
    asdfasdf
</div>
