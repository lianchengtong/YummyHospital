<?php


/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\MyPatient */
// 就诊人管理列表

$this->title    = "就诊人";
$this->showTab  = false;
$this->showSave = true;

echo \application\builder\Code::output("form.patient", [
    'model' => $model,
]);
?>

<script>
    $("body").on("click", "#action-btn-save", function (e) {
        e.preventDefault();
        $("#form").submit();
    });
</script>
