<?php

use skeeks\widget\simpleajaxuploader\Widget;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */
?>
<h1>Test</h1>

<?php $form = \yii\bootstrap\ActiveForm::begin() ?>
<?php
echo Widget::widget([
    "clientOptions" => [
        "name" => "test",
    ],
]);
?>
<?php \yii\bootstrap\ActiveForm::end(); ?>
