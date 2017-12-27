<?php

use application\builder\Code;
use common\utils\Cache;

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title      = "首页";
$this->showGoBack = false;
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

