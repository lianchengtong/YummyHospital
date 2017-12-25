<?php

use yii\helpers\Html;
use yii\helpers\Url;

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


<footer class="ui-footer ui-footer-stable ui-doctor-footer">
    <ul class="ui-tiled">
        <li class="tab-item appointment">
            <a href="<?= Url::to($tabItem['url']) ?>">在线预约</a>
        </li>
        <li class="tab-item ask">
            <a href="<?= Url::to($tabItem['url']) ?>">在线预约</a>
        </li>
    </ul>
</footer>


<section class="ui-container">
    <section class="ui-doctor-profile">
        <header class="ui-header ui-navbar ui-doctor-navbar">
            <i class="ui-icon-return" onclick="history.back()"></i>
            <h1>医生主页</h1>
        </header>

        <div class="ui-doctor-description">
            <div class="doctor-head-img">
                <?= Html::img("/images/avatar.png") ?>
            </div>
            <p class="doctor-name ui-font-kaiti">
                徐润三&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;国医大师
            </p>
        </div>

        <div class="ui-doctor-information">
            <ul class="ui-tiled">
                <?php for ($i = 0; $i < 4; $i++): ?>
                    <li>
                        <span class="title">接诊量</span>
                        <p class="count">15</p>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </section>

    <section class="ui-panel ui-border-t ui-border-b mb-15">
        <div class="ui-panel-heading ui-border-b">
            <div class="title">专业擅长</div>
            <div class="extend">展开</div>
        </div>
        <div class="ui-panel-body">
            <div class="ui-label-list">
                <label class="ui-label-s">金庸</label>
                <label class="ui-label-s">功夫</label>
                <label class="ui-label-s">悬疑</label>
                <label class="ui-label-s">盗墓笔记</label>
                <label class="ui-label-s">欢乐谷</label>
            </div>
        </div>
    </section>

    <section class="ui-panel ui-border-t ui-border-b mb-15">
        <div class="ui-panel-heading ui-border-b">
            <div class="title">职业医师</div>
            <div class="extend">展开</div>
        </div>
        <div class="ui-panel-body">
            我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师
        </div>
    </section>

    <section class="ui-panel ui-border-t ui-border-b mb-15">
        <div class="ui-panel-heading ui-border-b">
            <div class="title">同科室医生推荐</div>
            <div class="extend">展开</div>
        </div>
        <div class="ui-panel-body">
            <ul class="list-group">
                <?php for ($i = 0; $i < 10; $i++): ?>
                    <li>
                        <div class="head"><img src="/images/avatar.png" alt="" width="80" height="80"></div>
                        <div class="information">
                            <div class="name">李时珍</div>
                            <div class="content">国医大师</div>
                            <div class="content">妇科</div>
                        </div>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </section>
</section>

