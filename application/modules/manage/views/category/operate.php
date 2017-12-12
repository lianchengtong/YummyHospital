<?php
$this->title                   = '分类操作';
$this->params['breadcrumbs'][] = ['label' => '分类管理', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;

/** @var $mode \common\models\Category */
?>
<?= $this->render("_form", [
    'model' => $model,
]) ?>