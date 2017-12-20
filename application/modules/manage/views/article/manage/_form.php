<?php

use common\models\Category;
use rogeecn\SimpleAjaxUploader\SingleImage;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var  $inputFields \common\models\ArticleTypeField[] */
?>

<?= $form->field($model, 'type')->hiddenInput(['maxlength' => true]) ?>
<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-8">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'category')->dropDownList(Category::getFlatIndentList()) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <?= $form->field($model, 'content')->textarea(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, "head_image")->widget(SingleImage::className(), [

        ]); ?>
        <?= $form->field($model, 'keyword')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
    </div>
</div>
