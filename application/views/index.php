<?php

use rogeecn\UnSlider\Slider;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title      = "你好中国";
$this->showGoBack = false;


$gridItems = [
    [
        'label' => "门诊预约",
        'url'   => "javascript:void(0);",
        'image' => "/images/icon_tabbar.png",
    ],
    [
        'label' => "在线问诊",
        'url'   => "javascript:void(0);",
        'image' => "/images/icon_tabbar.png",
    ],
    [
        'label' => "一键复诊",
        'url'   => "javascript:void(0);",
        'image' => "/images/icon_tabbar.png",
    ],
    [
        'label' => "理疗预约",
        'url'   => "javascript:void(0);",
        'image' => "/images/icon_tabbar.png",
    ],
    [
        'label' => "品质中药",
        'url'   => "javascript:void(0);",
        'image' => "/images/icon_tabbar.png",
    ],
    [
        'label' => "我的医生",
        'url'   => "javascript:void(0);",
        'image' => "/images/icon_tabbar.png",
    ],
];
?>
<div class="weui-search-bar" id="searchBar">
    <form class="weui-search-bar__form">
        <div class="weui-search-bar__box">
            <i class="weui-icon-search"></i>
            <input type="search" class="weui-search-bar__input" id="searchInput" placeholder="搜索" required/>
            <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
        </div>
        <label class="weui-search-bar__label" id="searchText">
            <i class="weui-icon-search"></i>
            <span>搜索</span>
        </label>
    </form>
    <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
</div>

<div class="row">
    <?= Slider::widget([
        'slides' => [
            [
                'image' => '/images/cat1.jpg',
            ],
            [
                'image' => '/images/cat2.jpg',
            ],
            [
                'image' => '/images/cat3.jpg',
            ],
        ],
    ]) ?>
</div>

<div class="row">
    <div class="weui-grids">
        <?php foreach ($gridItems as $item): ?>
            <a href="<?= Url::to($item['url']) ?>" class="weui-grid">
                <div class="weui-grid__icon">
                    <?= Html::img($item['image']) ?>
                </div>
                <p class="weui-grid__label"><?= $item['label'] ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</div>


<div class="container">
    <a href="javascript:;" class="weui-btn weui-btn_primary">绿色按钮</a>
</div>
