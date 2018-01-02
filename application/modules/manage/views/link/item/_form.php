<?php

use common\models\LinkGroupItem;
/* @var $this yii\web\View */
/* @var $model common\models\LinkGroupItem */

$list = LinkGroupItem::getFlatIndentList($model->link_group_id, true);
?>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'type')->dropDownList(LinkGroupItem::typeList()) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'pid')->dropDownList($list) ?>
    </div>
</div>
<?= $form->field($model, 'data')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'options')->widget(\rogeecn\AceEditor\AceEditor::className(), [
    'mode'  => 'json',
    'theme' => 'github',
]) ?>
