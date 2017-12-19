<?php

use common\models\DoctorServiceTime;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DoctorServiceTime */
/* @var $form yii\widgets\ActiveForm */

$this->title                   = '创建 Doctor Service Time';
$this->params['breadcrumbs'][] = ['label' => 'Doctor Service Times', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
if ($model->isNewRecord) {
    $model->mode          = 0;
    $model->week          = 0;
    $model->max_time_long = 5;
}
?>

<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-body">
        <?= $form->field($model, 'mode', ['inline' => true])
                 ->radioList(DoctorServiceTime::modeList(), [
                     'class' => 'mode',
                 ]) ?>

        <?= $form->field($model, 'max_time_long', ['inline' => true])
                 ->textInput()
        ?>

        <div class="well">
            <div id="month-mode" class="mode-type" style="display: none;">
                <?= $this->render("_mode_month", [
                    'form'  => $form,
                    'model' => $model,
                ]) ?>
            </div>

            <div id="week-mode" class="mode-type" style="display: none;">
                <?= $this->render("_mode_week", [
                    'form'  => $form,
                    'model' => $model,
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'am')
                         ->label("上午开始")
                         ->dropDownList(DoctorServiceTime::clockRange(2, 12), [
                             'name'  => sprintf("%s[am][begin]", $model->formName()),
                             'value' => $model->am['begin'],
                         ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'am')
                         ->label("上午结束")
                         ->dropDownList(DoctorServiceTime::clockRange(2, 12), [
                             'name'  => sprintf("%s[am][end]", $model->formName()),
                             'value' => $model->am['end'],
                         ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'pm')
                         ->label("下午开始")
                         ->dropDownList(DoctorServiceTime::clockRange(12, 24), [
                             'name'  => sprintf("%s[pm][begin]", $model->formName()),
                             'value' => $model->pm['begin'],
                         ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'pm')
                         ->label("下午结束")
                         ->dropDownList(DoctorServiceTime::clockRange(12, 24), [
                             'name'  => sprintf("%s[pm][end]", $model->formName()),
                             'value' => $model->pm['end'],
                         ]) ?>
            </div>
        </div>

    </div>
    <div class="panel-footer text-right">
        <?= Html::submitButton("提交", ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script>
    function selectMode(mode) {
        $(".mode-type").hide();
        if (mode == 0) {
            $("#week-mode").show();
            return
        }
        $("#month-mode").show();
    }

    $(function () {
        selectMode(<?=$model->mode?>);
        $(".mode input:radio").change(function () {
            var mode = $(this).val();
            selectMode(mode);
        });
    })
</script>
