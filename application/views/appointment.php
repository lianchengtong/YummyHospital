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
            <li>
                <a href="<?= Url::to($url) ?>" class="ui-avatar">
                    <?= Html::img($item['image'], ['class' => 'weui-media-box__thumb']) ?>
                </a>
                <div class="ui-list-info ui-border-t">
                    <div class="ui-flex">

                        div.
                    <h4 class="ui-nowrap">
                        <?= $item['title'] ?>
                        <span class="subtitle"><?= $item['subTitle'] ?></span>
                    </h4>
                    <p class="ui-nowrap">擅长：<?= $item['favor'] ?></p>
                    <p><?= $item['description'] ?></p>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
