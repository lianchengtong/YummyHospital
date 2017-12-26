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


$patients = [
    '杨豪，男，27岁',
    '杨豪，男，28岁',
    '杨豪，男，29岁',
    '杨豪，男，29岁',
];
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

    <section class="mb-20 ui-panel">
        <div class="ui-panel-body">
            <div class="row ui-form">
                <div class="ui-form-item ui-border-b">
                    <label>就诊日期</label>
                    <div class="ui-select">
                        <?= Html::dropDownList("patient", 0, $patients) ?>
                    </div>
                </div>

                <div class="ui-doctor-service-time-wrapper ui-border-b">
                    <div class="">
                        <div class="ui-form-item-title">就诊时间</div>
                        <div class="ui-doctor-service-time">
                            <?php for ($i = 0; $i < 20; $i++): ?>
                                <a class="ui-label-s">14:20</a>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>

                <div class="ui-form-item">
                    <label>就诊人</label>
                    <div class="ui-select">
                        <?= Html::dropDownList("patient", 0, $patients) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="mb-20 ui-panel">
        <div class="ui-panel-heading">
            <div class="title">专业擅长</div>
            <div class="extend ui-arrowlink">展开</div>
        </div>
        <div class="ui-panel-body">
            <div class="ui-label-list ui-doctor-label">
                <label class="ui-label-s">金庸</label>
                <label class="ui-label-s">功夫</label>
                <label class="ui-label-s">悬疑</label>
                <label class="ui-label-s">盗墓笔记</label>
                <label class="ui-label-s">欢乐谷</label>
            </div>
        </div>
    </section>

    <section class="ui-panel mb-20">
        <div class="ui-panel-heading">
            <div class="title">职业医师</div>
            <div class="extend ui-arrowlink">展开</div>
        </div>
        <div class="ui-panel-body ui-txt-info ui-txt-size-14">
            我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师，我是一个职业医师
        </div>
    </section>

    <section class="ui-panel mb-20">
        <div class="ui-panel-heading">
            <div class="title">患者评价</div>
            <div class="extend ui-arrowlink">展开</div>
        </div>
        <div class="ui-panel-body ui-patient-feedback">
            <div class="ui-patient-info ui-flex ui-justify-flex ui-flex-align-center">
                <div class="ui-head-info">
                    <div class=" ui-flex ui-flex-align-center">
                        <div class="ui-avatar-s">
                            <img src="/images/avatar.png" alt="">
                        </div>
                        <div class="ui-patient-name">
                            小**
                        </div>
                        <div class="ui-patient-status">已就诊</div>
                    </div>
                </div>

                <div class="ui-patient-datetime ui-txt-info">2017-01-02</div>
            </div>
            <div class="ui-patient-evaluate  ui-flex ui-flex-align-center">
                <?php for ($i = 0; $i < 5; $i++): ?>
                    <i class="ui-icon-star"></i>
                <?php endfor; ?>
            </div>

            <div class="ui-feedback ui-txt-info ui-txt-size-14">
                张主任一书高超，对病人认真负责，态度和蔼，张主任一书高超，对病人认真负责，态度和蔼，张主任一书高超，对病人认真负责，态度和蔼，张主任一书高超，对病人认真负责，态度和蔼，张主任一书高超，对病人认真负责，态度和蔼，张主任一书高超，对病。
            </div>
            <div class="ui-patient-btn-view-all">
                <a class="ui-btn-lg">查看全部评价</a>
            </div>
        </div>
    </section>

    <section class="ui-panel mb-20">
        <div class="ui-panel-heading">
            <div class="title">同科室医生推荐</div>
            <div class="extend ui-arrowlink">展开</div>
        </div>
        <div class="ui-panel-body">
            <ul class="list-group">
                <?php for ($i = 0; $i < 10; $i++): ?>
                    <li>
                        <div class="head"><img src="/images/avatar.png" alt="" width="80" height="80"></div>
                        <div class="information ui-txt-size-14">
                            <div>李时珍</div>
                            <div class="ui-txt-info">国医大师</div>
                            <div class="ui-txt-info">妇科</div>
                        </div>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </section>
</section>

