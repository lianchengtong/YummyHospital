<?php


/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "门诊预约";

\application\builder\Code::output("page.doctor-appointment-list", [
    'items' => \common\utils\Cache::dataProvider("page.doctor-appointment-list", function () {
        $doctorItem = [
            'title'       => '许润三',
            'subTitle'    => '国家医生',
            'url'         => '#',
            'image'       => '/images/avatar.png',
            'favor'       => '由各种物质组成的巨型球状天体',
            'description' => '由各种物质组成的巨型球状天体，叫做星球。星球有一定的形状，有自己的运行轨道。',
        ];
        $items      = array_pad([], 10, $doctorItem);

        return $items;
    }),
]);
