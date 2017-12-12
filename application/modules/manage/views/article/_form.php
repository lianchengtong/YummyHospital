<?php

use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
?>

<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-8">
                <?= $form->field($model, 'title')->textInput(['maxlength' => TRUE]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'category')->dropDownList(Category::getFlatIndentList()) ?>
            </div>
        </div>
        <?= $form->field($model, 'content')->textarea(['maxlength' => TRUE]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'slug')->textInput(['maxlength' => TRUE]) ?>
        <?= $form->field($model, 'head_image')->textInput(['maxlength' => TRUE]) ?>
        <?= $form->field($model, 'keyword')->textInput(['maxlength' => TRUE]) ?>
        <?= $form->field($model, 'description')->textarea(['maxlength' => TRUE]) ?>
    </div>
</div>

