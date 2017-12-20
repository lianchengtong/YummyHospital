<?php

use common\models\Category;
use rogeecn\SimpleAjaxUploader\SingleImage;

/* @var $this yii\web\View */
/* @var $model \application\modules\manage\forms\ArticleForm */
/* @var  $typeFields \common\models\ArticleTypeField[] */

?>

<?= \yii\helpers\Html::activeHiddenInput($model, "type") ?>
<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-8">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <?php foreach ($typeFields as $typeField): ?>
            <?= $typeField->showInput($model, false) ?>
        <?php endforeach; ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'category')->dropDownList(Category::getFlatIndentList()) ?>
        <?= $form->field($model, "head_image")->widget(SingleImage::className(), [

        ]); ?>
        <?= $form->field($model, 'keyword')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

        <?php foreach ($typeFields as $typeField): ?>
            <?= $typeField->showInput($model, true) ?>
        <?php endforeach; ?>
    </div>
</div>
