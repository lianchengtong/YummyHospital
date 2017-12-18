<?php

use common\models\Category;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$uploadInputName = sprintf("%s[%s]", $model->formName(), "head_image");
?>

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
        <?= $form->field($model, "head_image")->hint("多个图片将选择最后一张图片使用")->widget(\kartik\file\FileInput::className(), [
            'options'       => [
                'accept'   => 'images/*',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'uploadExtraData' => [
                    'name' => $uploadInputName,
                ],
                'initialPreview'  => [$model->head_image],
                'uploadUrl'       => Url::to(['@admin/misc/upload']),
                'uploadAsync'     => true,
                'maxFileCount'    => 1,
            ],
            'pluginEvents'  => [
                'fileuploaded' => sprintf('function (object,data){$("input[name=\'%s\']:eq(0)").val($("input[name=\'%s\']:eq(0)").val()+', '+data.response.imageUrl)}', $uploadInputName),
            ],
        ]); ?>
        <?= $form->field($model, 'keyword')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
    </div>
</div>

