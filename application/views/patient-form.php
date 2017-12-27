<?php


/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\MyPatient */

$this->title    = "就诊人";
$this->showSave = "true";

echo \application\builder\Code::output("form.patient", [
    'model' => $model,
]);