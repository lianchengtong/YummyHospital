<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\Order */
/* @var $doctorModel \common\models\Doctor */

$this->title   = "确认订单";
$this->showTab = false;
?>

<footer class="ui-footer ui-footer-stable  ui-border-t ui-order-footer">
    <div class="tab-item ui-price-wrapper">
        <div class="ui-price-flex-wrapper">
            <?php
            $doctorServicePrice = \common\models\DoctorServiceTime::getDoctorServicePrice($doctorModel->id);
            ?>
            实付款: <span class="ui-txt-danger ui-price-show">&yen;<?= $doctorServicePrice ?></span>
        </div>
    </div>
    <div class="tab-item ui-order-ensure action-order-ensure">确认订单</div>
</footer>


<?php $form = \yii\widgets\ActiveForm::begin() ?>

<?= \application\builder\Code::output("element.order.patient-selector") ?>

<div class="ui-form ui-border-t mb-20">
    <div class="ui-form-item ui-border-b">
        <label>医生姓名</label>
        <?= \yii\helpers\Html::textInput("doctor_name", $doctorModel->name, ['readonly' => true]) ?>
    </div>

    <div class="ui-form-item ui-border-b">
        <label>就诊医院</label>
        <?= \yii\helpers\Html::textInput("hospital", "汉典中医医院", ['readonly' => true]) ?>
    </div>

    <div class="ui-form-item ui-border-b">
        <label>就诊科室</label>
        <div class="ui-select">
            <?php
            $doctorDepartment = \common\models\DoctorDepartment::getDepartmentList($doctorModel->id);
            echo \yii\helpers\Html::dropDownList("department", null, $doctorDepartment);
            ?>
        </div>
    </div>

    <div class="ui-form-item ui-border-b">
        <label>就诊地址</label>
        <?= \yii\helpers\Html::textInput("location", "朝阳区石佛营东里133号", ['readonly' => true]) ?>
    </div>

    <div class="ui-form-item ui-border-b">
        <label>预约时间</label>
        <?= \yii\helpers\Html::textInput("time", \common\utils\Request::input("date"), ['readonly' => true]) ?>
    </div>
</div>

<?= \application\builder\Code::output("element.order.pay-channel-selector") ?>
<?= \application\builder\Code::output("element.order.healthy-ticket") ?>
<?= \application\builder\Code::output("element.order.healthy-coin") ?>
<?= \application\builder\Code::output("element.order.order-price", [
    'doctorModel' => $doctorModel,
]) ?>
<?= \application\builder\Code::output("element.order.appointment-term-link") ?>

<?php \yii\widgets\ActiveForm::end() ?>
