<?php

use application\builder\Code;
use common\utils\Cache;

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title      = "首页";
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
<?= Code::output("index.search-box") ?>

<?= Code::output("index.carousel", [
    'images' => Cache::dataProvider("index.carousel", function () {
        $articleList = \common\models\Article::find()
                                             ->where(['type' => 2])
                                             ->limit(3)
                                             ->orderBy(['id' => SORT_DESC])
                                             ->all();
        $retData     = [];
        /** @var \common\models\Article $article */
        foreach ($articleList as $article) {
            $retData[] = [
                'image' => $article->head_image,
                'url'   => $article->getFieldModelData("link"),
            ];
        }

        return $retData;
    }),
]) ?>

<?= Code::output("index.9-grids") ?>

