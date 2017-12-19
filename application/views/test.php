<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */
?>
<?=$html?>


<?php $form = \yii\bootstrap\ActiveForm::begin() ?>
<?php
$model->key = "/upload/2017/12/19/c020598be240e3b671dd02d076253f92.jpg,/upload/2017/12/19/c020598be240e3b671dd02d076253f92.jpg";
$model->key .= ",/upload/2017/12/19/c020598be240e3b671dd02d076253f92.jpg,/upload/2017/12/19/c020598be240e3b671dd02d076253f92.jpg";
$model->key .= ",/upload/2017/12/19/c020598be240e3b671dd02d076253f92.jpg,/upload/2017/12/19/c020598be240e3b671dd02d076253f92.jpg";
$model->key .= ",/upload/2017/12/19/c020598be240e3b671dd02d076253f92.jpg,/upload/2017/12/19/c020598be240e3b671dd02d076253f92.jpg";
$model->key .= ",/upload/2017/12/19/c020598be240e3b671dd02d076253f92.jpg,/upload/2017/12/19/c020598be240e3b671dd02d076253f92.jpg";
echo $form->field($model, "key")->widget(\rogeecn\SimpleAjaxUploader\MultipleImage::className(), [
]);
?>

<?php
$model->key = "/upload/2017/12/19/c020598be240e3b671dd02d076253f92.jpg";
echo $form->field($model, "key")->widget(\rogeecn\SimpleAjaxUploader\SingleImage::className(), [
]);
?>
<?php \yii\bootstrap\ActiveForm::end(); ?>