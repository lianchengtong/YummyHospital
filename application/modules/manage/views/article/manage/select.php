<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\Article */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $models \common\models\ArticleType[] */

$this->title                   = '选择发布类型';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        文章类型列表
    </div>
    <div class="list-group">
        <?php foreach ($models as $model): ?>
            <a href="<?= Url::to(["@admin/article/manage/create", "type" => $model->slug]) ?>" class="list-group-item">
                <h4 class="list-group-item-heading"><?= $model->name ?></h4>
                <p class="list-group-item-text"><?= $model->description ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</div>
