<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */
?>
    <style>
        .thumbnail {
            display: inline-block;
            margin: 10px 5px 10px 0;
            width: 120px;
            height: 120px;
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
        }
    </style>

<?php $form = \yii\bootstrap\ActiveForm::begin() ?>
<?php
$model->key = "/upload/2017/12/18/a03a696657800efee1bd6f9b3fc748a4.png,/upload/2017/12/18/a03a696657800efee1bd6f9b3fc748a4.png";
echo $form->field($model, "key")->widget(\rogeecn\SimpleAjaxUploader\MultipleImage::className(), [
]);
?>

<?php
$model->key = "/upload/2017/12/18/a03a696657800efee1bd6f9b3fc748a4.png";
echo $form->field($model, "key")->widget(\rogeecn\SimpleAjaxUploader\SingleImage::className(), [
]);
?>
<?php \yii\bootstrap\ActiveForm::end(); ?>