<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CodeBlock */

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Code Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p class="text-right">
</p>

<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <div class="pull-right">
            <?= Html::a('编辑', ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary btn-sm',
            ]) ?>
        </div>
    </div>
    <?= \rogeecn\AceEditor\AceEditor::widget([
        'mode'      => 'html',
        'theme'     => 'github',
        'model'     => $model,
        'attribute' => 'code',
        'readOnly'  => true,
    ]) ?>
</div>

