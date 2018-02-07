<?php
$linkList = \common\models\LinkGroup::getLinkItems("online-ask-department-list");
?>
<div class="page-ask-show">
    <div class="show-banner">

    </div>

    <div class="search-box">
        <div class="search-input-container">
            <div class="search-input-wrapper">
                <i class="ui-icon-search"></i>
                <input type="text" class="search-input-box">
            </div>
        </div>
        <div class="search-btn">
            <button class="ui-btn-s ui-btn-main">搜索</button>
        </div>
    </div>

    <div class="comment-show">
        <ul class="ui-tiled">
            <li class="item first">
                <div class="title">
                    <i class="ui-icon-commented"></i>
                    <span>快速咨询</span>
                </div>
                <div class="info">
                    30秒内医生快速回答
                </div>
            </li>

            <li class="item">
                <div class="title">
                    <i class="ui-icon-personal"></i>
                    <span>名医咨询</span>
                </div>
                <div class="info">
                    国家级名老中医回复
                </div>
            </li>
        </ul>
    </div>

    <div class="department-list">
        <h2>按科室找医生</h2>
        <div class="row ui-9-grids-wrapper">
            <div class="ui-9-grids">
                <?php foreach ($linkList as $linkItem): ?>
                    <a href="<?= $linkItem->getUrl() ?>" class="ui-item">
                        <p class="ui-grid-label"><?=$linkItem->name?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="ask-list">
        <h2>咨询动态</h2>
        <ul>
            <?php for ($i = 0; $i < 10; $i++): ?>
                <li>
                    <a href="#" class="head"><img src="/images/grid-0.png" alt=""></a>
                    <div class="doctor-info">
                        <div class="name">徐润三 国医大师</div>
                        <div class="info">张三 刚刚向专家发起了提问</div>
                    </div>
                    <div class="time">
                        刚刚
                    </div>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
</div>