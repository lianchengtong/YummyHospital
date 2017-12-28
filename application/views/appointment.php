<?php


/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "门诊预约";

$tagName = \common\utils\Request::input("tag");
$items   = \common\utils\Cache::dataProvider(
    "page.doctor-appointment-list-" . $tagName,
    function () use ($tagName) {
        return \common\models\Doctor::getByTag($tagName);
    }
);

echo \application\builder\Code::output("page.doctor-appointment-list", [
    'items' => $items,
]);
