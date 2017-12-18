<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */
?>
    <h1>Test</h1>

<?php $form = \yii\bootstrap\ActiveForm::begin() ?>
<?php
echo $form->field($model, "key")->widget(\rogeecn\SimpleAjaxUploader\SingleImage::className(), [
]);
?>
<?php \yii\bootstrap\ActiveForm::end(); ?>