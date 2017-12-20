<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleTypeField */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Article Type Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p class="text-right">
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
</p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            'type_id',
            'name',
            'description',
            'class',
            'configure',
            'order',
    ],
]) ?>

