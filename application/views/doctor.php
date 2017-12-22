<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "门诊预约";

$doctorItem = [
    'title'       => '许润三',
    'subTitle'    => '国家医生',
    'url'         => '#',
    'image'       => '/images/avatar.png',
    'favor'       => '由各种物质组成的巨型球状天体',
    'description' => '由各种物质组成的巨型球状天体，叫做星球。星球有一定的形状，有自己的运行轨道。',
];
$items      = array_pad([], 10, $doctorItem);
?>

<div class="row weui-panel weui-panel_access weui-flex">
    <div class="weui-panel__bd weui-flex__item">
        <?php foreach ($items as $item): ?>
            <div class="weui-media-box weui-media-box_appmsg">
                <a href="<?= Url::to($url) ?>" class="weui-media-box__hd round">
                    <?= Html::img($item['image'], ['class' => 'weui-media-box__thumb']) ?>
                </a>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title">
                        <?= $item['title'] ?>
                        <span class="subtitle"><?= $item['subTitle'] ?></span>
                    </h4>
                    <div class="weui-flex">
                        <div class="weui-flex__item">
                            <p class="weui-media-box__desc">擅长：<?= $item['favor'] ?></p>
                            <p class="weui-media-box__desc"><?= $item['description'] ?></p>
                        </div>
                        <div class="action-buttons">
                            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary">页面主操</a>
                            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary">页面主操</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
