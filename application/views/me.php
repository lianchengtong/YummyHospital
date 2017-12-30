<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title      = "个人中心";
$this->showGoBack = false;
?>

<?= \application\builder\Code::output("element.me.head-info") ?>
<?= \application\builder\Code::output("element.me.4-grid") ?>
<?= \application\builder\Code::output("element.me.link-list") ?>