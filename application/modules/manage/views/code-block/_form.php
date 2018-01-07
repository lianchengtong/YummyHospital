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
    'mode'  => 'php',
    'enableVim'  => \common\models\WebsiteConfig::getValueByKey("global.enable-ace-vim"),
    'theme' => 'github',
    'containerOptions'=>[
        'style' => 'width: 100%; min-height: 500px;border: 1px solid #ddd',
    ]
]) ?>
