<?php
use common\models\LinkGroupItem;

/* @var $this yii\web\View */
/* @var $model common\models\LinkGroupItem */
?>
<?= $form->field($model, 'name')->textInput(['maxlength' => TRUE]) ?>
<?= $form->field($model, 'slug')->textInput(['maxlength' => TRUE]) ?>
<?= $form->field($model, 'type')->dropDownList(LinkGroupItem::typeList()) ?>
<?= $form->field($model, 'pid')->dropDownList(LinkGroupItem::getFlatIndentList(TRUE)) ?>
<?= $form->field($model, 'data')->textarea(['maxlength' => TRUE]) ?>


