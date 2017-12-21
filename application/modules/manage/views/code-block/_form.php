<?php

/* @var $this yii\web\View */
/* @var $model common\models\CodeBlock */
?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<?= $form->field($model, 'code')->widget(\rogeecn\AceEditor\AceEditor::className(), [
    'mode'  => 'html',
    'theme' => 'github',
]) ?>
