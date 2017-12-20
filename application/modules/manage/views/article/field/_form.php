<?php

/* @var $this yii\web\View */
/* @var $model common\models\ArticleTypeField */
?>


<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'order')->textInput() ?>
    </div>
</div>

<?= $form->field($model, 'configure')->textarea(['maxlength' => true, 'rows' => 20]) ?>



