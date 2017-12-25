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

<div class="row">
    <ul class="ui-list ui-border-tb">
        <?php foreach ($items as $item): ?>
            <li class="doctor-list">
                <a href="<?= Url::to($url) ?>" class="ui-avatar">
                    <?= Html::img($item['image'], ['class' => 'weui-media-box__thumb']) ?>
                </a>
                <div class="ui-list-info ui-border-t">
                    <div class="ui-row-flex">
                        <div class="ui-col doctor-info">
                            <h4 class="ui-nowrap">
                                <?= $item['title'] ?>
                                <span class="subtitle"><?= $item['subTitle'] ?></span>
                            </h4>
                            <div class="ui-label-list ui-no-margin">
                                <span class="ui-label-head">擅长:</span>
                                <label class="ui-label-s">金庸</label>
                                <label class="ui-label-s">功夫</label>
                                <label class="ui-label-s">欢乐谷</label>
                            </div>
                            <p><?= $item['description'] ?></p>
                        </div>
                        <div class="ui-flex ui-flex-ver ui-flex-pack-center ui-flex-align-start ui-btn-group-wrapper">
                            <a href="#" class="ui-btn-s">在线咨询</a>
                            <a href="#" class="ui-btn-s">病情诊断</a>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
