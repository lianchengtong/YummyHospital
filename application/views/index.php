<?php

use rogeecn\UnSlider\Slider;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title      = "你好中国";
$this->showGoBack = false;


$gridItems      = [
    [
        'label' => "门诊预约",
        'url'   => "javascript:void(0);",
        'image' => "/images/grid-0.png",
    ],
    [
        'label' => "在线问诊",
        'url'   => "javascript:void(0);",
        'image' => "/images/grid-1.png",
    ],
    [
        'label' => "一键复诊",
        'url'   => "javascript:void(0);",
        'image' => "/images/grid-2.png",
    ],
    [
        'label' => "理疗预约",
        'url'   => "javascript:void(0);",
        'image' => "/images/grid-3.png",
    ],
    [
        'label' => "品质中药",
        'url'   => "javascript:void(0);",
        'image' => "/images/grid-4.png",
    ],
    [
        'label' => "我的医生",
        'url'   => "javascript:void(0);",
        'image' => "/images/grid-5.png",
    ],
];
$gridGroupItems = array_chunk($gridItems, 3);
?>
<div class="ui-searchbar-wrap ui-border-b">
    <div class="ui-searchbar ui-border-radius">
        <i class="ui-icon-search"></i>
        <div class="ui-searchbar-text">请输入病情</div>
        <div class="ui-searchbar-input">
            <input value="" type="tel" placeholder="请输入病情" autocapitalize="off">
        </div>
        <i class="ui-icon-close"></i>
    </div>
    <button class="ui-searchbar-cancel">取消</button>
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

<div class="row ui-9-grids">
    <?php foreach ($gridGroupItems as $gridItems): ?>
        <div class="ui-3-grid">
            <?php foreach ($gridItems as $item): ?>
                <a href="<?= Url::to($item['url']) ?>" class="ui-col">
                    <div class="ui-grid-icon">
                        <?= Html::img($item['image']) ?>
                    </div>
                    <p class="ui-grid-label"><?= $item['label'] ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

<script>
    $(function () {
        $('.ui-searchbar').click(function () {
            $('.ui-searchbar-wrap').addClass('focus');
            $('.ui-searchbar-input input').focus();
        });
        $('.ui-searchbar-cancel').click(function () {
            $('.ui-searchbar-wrap').removeClass('focus');
        });
        $('.ui-icon-close').click(function () {
            $('.ui-searchbar-input input').val("");
        });
    })
</script>
