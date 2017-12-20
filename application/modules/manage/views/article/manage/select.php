<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\Article */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $models \common\models\ArticleType[] */

$this->title                   = '选择发布类型';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <?php foreach ($models as $model): ?>
        <div class="panel-body">
            <h2>
                <?= Html::a($model->name, ["@admin/article/manage/create", "type" => $model->slug]) ?>
            </h2>
            <p><?= $model->description ?></p>
        </div>
    <?php endforeach; ?>
</div>
