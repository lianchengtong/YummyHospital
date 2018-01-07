<?php

use common\models\DoctorServiceTime;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DoctorServiceTime */
/* @var $form yii\widgets\ActiveForm */

$this->title                   = '医生问诊时间';
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
        <?= $form->field($model, 'price')
                 ->textInput()
        ?>

        <?= $form->field($model, 'max_time_long')
                 ->textInput()
        ?>

        <?= $form->field($model, 'ticket_count')
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
                <div class="panel panel-default">
                    <div class="panel-heading">上午接诊时段</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'am')
                                         ->label("上午开始")
                                         ->dropDownList(DoctorServiceTime::numberRange(2, 12), [
                                             'name'  => sprintf("%s[am][begin]", $model->formName()),
                                             'value' => $model->am['begin'],
                                         ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'am')
                                         ->label("上午结束")
                                         ->dropDownList(DoctorServiceTime::numberRange(2, 12), [
                                             'name'  => sprintf("%s[am][end]", $model->formName()),
                                             'value' => $model->am['end'],
                                         ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">下午接诊时段</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'pm')
                                         ->label("下午开始")
                                         ->dropDownList(DoctorServiceTime::numberRange(12, 24), [
                                             'name'  => sprintf("%s[pm][begin]", $model->formName()),
                                             'value' => $model->pm['begin'],
                                         ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'pm')
                                         ->label("下午结束")
                                         ->dropDownList(DoctorServiceTime::numberRange(12, 24), [
                                             'name'  => sprintf("%s[pm][end]", $model->formName()),
                                             'value' => $model->pm['end'],
                                         ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $form->field($model, 'time_range')->label("服务时段号源设置")->textarea([
                'rows'=>10,
                'placeholder'=>'格式：8:20-9:00|12 (开始时间-结束时间|号源数量) 多个时间段一行一个'
        ]) ?>
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
