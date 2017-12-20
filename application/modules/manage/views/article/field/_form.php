<?php

/* @var $this yii\web\View */
/* @var $model common\models\ArticleTypeField */
?>


<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'field')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'order')->textInput() ?>
    </div>
    <div class="col-md-4">
        <div style="margin-top: 25px">
            <?= $form->field($model, 'side_show')->checkbox() ?>
        </div>
    </div>
</div>

<?= $form->field($model, 'configure')->widget(\rogeecn\AceEditor\AceEditor::className(), [
    'mode'     => 'json', // programing language mode. Default "html"
    'theme'    => 'github', // editor theme. Default "github"
    'readOnly' => 'false' // Read-only mode on/off = true/false. Default "false"
]) ?>



