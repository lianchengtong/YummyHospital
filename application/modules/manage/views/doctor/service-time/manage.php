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
?>

<?php $form = ActiveForm::begin(); ?>
<?php
$items = [
    [
        'label'   => "按周",
        'content' => $this->render("_mode_week", [
            'form'  => $form,
            'model' => $model,
        ]),
    ],
    [
        'label'   => "按月",
        'content' => $this->render("_mode_month", [
            'form'  => $form,
            'model' => $model,
        ]),
    ],
];
?>
<div class="panel panel-default">
    <div class="panel-heading">
    </div>
    <div class="panel-body">
        <?= $form->field($model, 'mode', ['inline' => true])->radioList(DoctorServiceTime::modeList()) ?>
        <?= $form->field($model, 'max_time_long', ['inline' => true])->textInput() ?>
        <div class="well">
            <?php
            echo \yii\bootstrap\Tabs::widget([
                'items' => $items,
            ]);
            ?>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'am')->label("上午开始")->dropDownList(DoctorServiceTime::clockRange(2, 12), ['name' => sprintf("%s[am][begin]", $model->formName())]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'am')->label("上午结束")->dropDownList(DoctorServiceTime::clockRange(2, 12), ['name' => sprintf("%s[am][end]", $model->formName())]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'pm')->label("下午开始")->dropDownList(DoctorServiceTime::clockRange(12, 24), ['name' => sprintf("%s[pm][begin]", $model->formName())]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'pm')->label("下午结束")->dropDownList(DoctorServiceTime::clockRange(12, 24), ['name' => sprintf("%s[pm][end]", $model->formName())]) ?>
            </div>
        </div>

    </div>
    <div class="panel-footer text-right">
        <?= Html::submitButton("提交", ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
