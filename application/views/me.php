<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "个人中心";
?>

<section class="ui-page-me-banner mb-20">
    <div class="ui-backdrop-filter"></div>

    <div class="head-wrapper">
        <img src="/images/avatar.png">
    </div>
    <div class="user-summary">
        <div class="user-id">
            123123123
        </div>
        <div class="user-score">
            我的积分： 10000
        </div>
    </div>
</section>

<section class="ui-page-me-action-icon mb-20">
    <ul class="ui-tiled">
        <?php for ($i = 0; $i < 4; $i++): ?>
            <li>
                <a href="#">
                    <div class="img-wrapper">
                        <img src="/images/tab-0.png"/>
                    </div>
                    <div><span>我的预约</span></div>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</section>

<section class="ui-page-me-service-list mb-20">
    <div class="ui-arrowlink ui-border-b">
        <a href="#">我的评价</a>
    </div>
    <div class="ui-arrowlink ui-border-b">
        <a href="#">我的订单</a>
    </div>
    <div class="ui-arrowlink ui-border-b">
        <a href="#">我的医生</a>
    </div>
    <div class="ui-arrowlink ui-border-b">
        <a href="#">收货地址管理</a>
    </div>
    <div class="ui-arrowlink">
        <a href="#">我的邀请码</a>
    </div>
</section>