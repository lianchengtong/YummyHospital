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

<div class="doctor-info">

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

    <div class="doctor-row">
        <div class="title">
            <div>专业擅长</div>
            <div class="open">
                展开
                <i class="fa fa-chevron-right"></i>
            </div>
        </div>
        <div class="body">
            <div class="labels">
                <span class="label">月经</span>
                <span class="label">月经不调</span>
                <span class="label">月经</span>
                <span class="label">月经不调</span>
                <span class="label">月经</span>
                <span class="label">月经不调</span>
                <span class="label">月经</span>
                <span class="label">月经不调</span>
            </div>
        </div>
    </div>


    <div class="doctor-row">
        <div class="title">
            <div>职业医师</div>
            <div class="open">
                展开
                <i class="fa fa-chevron-right"></i>
            </div>
        </div>
        <div class="body">
            <div class="content">
                我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师
            </div>
        </div>
    </div>

    <div class="doctor-row">
        <div class="title">
            <div>同科室医生推荐</div>
            <div class="open">
                展开
                <i class="fa fa-chevron-right"></i>
            </div>
        </div>
        <div class="body">
            <div class="scroll-list">
                <?php for ($i = 0; $i < 10; $i++): ?>
                    <div class="scroll-list-item">
                        <div class="head"><img src="/images/avatar.png" alt="" width="80" height="80"></div>
                        <div class="information">
                            <div class="name">李时珍</div>
                            <div class="content">国医大师</div>
                            <div class="content">妇科</div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>
<div class="doctor-btn">
    <div class="appointment">在线预约</div>
    <div class="ask">在线预约</div>
</div>
