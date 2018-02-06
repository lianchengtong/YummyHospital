<?php

use common\models\Department;
use common\models\DoctorLevel;
use crazydb\ueditor\UEditor;
use rogeecn\SimpleAjaxUploader\SingleImage;

/* @var $this yii\web\View */
/* @var $model common\models\Doctor */
?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, "head_image")->widget(SingleImage::className()); ?>
        <?= $form->field($model, 'level')->dropDownList(DoctorLevel::levelList()) ?>
        <?= $form->field($model, 'work_time')->textInput() ?>
        <?= $form->field($model, 'rank')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'enable_ask', ['inline' => true])->radioList(['否', '是']) ?>
        <?= $form->field($model, 'ask_price')->textInput() ?>
        <?= $form->field($model, 'type')->dropDownList(\common\models\Doctor::getTypeList()) ?>
    </div>
    <div class="col-md-9">
        <?= $form->field($model, 'department', ['inline' => true])
                 ->checkboxList(Department::getList())
        ?>
        <?= $form->field($model, 'tag')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'summary')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'introduce')->widget(UEditor::className()) ?>
    </div>
</div>
