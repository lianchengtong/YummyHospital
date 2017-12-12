<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Doctor */

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Doctors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p class="text-right">
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
</p>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3><?= $model->name ?></h3>
    </div>
    <div class="panel-body">
        <h2>简介</h2>
        <?= $model->summary ?>
    </div>
    <div class="panel-body">
        <h2>详情</h2>
        <?= $model->introduce ?>
    </div>
</div>

