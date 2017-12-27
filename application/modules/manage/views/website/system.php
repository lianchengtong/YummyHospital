<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WebsiteConfig */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = '备份/恢复';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <div class="pull-right">
            <?= Html::a("下载备份配置", ['@admin/website/system/backup'], [
                'class'  => 'btn btn-primary',
                'target' => '_blank',
            ]) ?>
        </div>
    </div>
    <?php if (!empty($restoreInfo)): ?>
        <ul class="list-group">
            <?php foreach ($restoreInfo as $restoreItem): ?>
                <li class="list-group-item"><?= Html::encode($restoreItem) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php if (!empty($errmsg)): ?>
        <div class="panel-body">
            <div class="alert alert-warning"><?= $errmsg ?></div>
        </div>
    <?php endif; ?>
    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]) ?>
    <div class="panel-body">
        <?= Html::fileInput("backup") ?>
    </div>
    <div class="panel-body">
        <?= Html::submitButton("恢复配置", ['class' => 'btn btn-success']) ?>
    </div>
    <?php \yii\bootstrap\ActiveForm::end() ?>
</div>
