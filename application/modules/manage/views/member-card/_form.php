<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MemberCard */
?>

<?= $form->field($model, 'name')->textInput() ?>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'price')->textInput() ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'discount')->textInput() ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'pay_discount')->textInput() ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'time_long')->textInput() ?>
    </div>
</div>

<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
<?= $form->field($model, 'options')->widget(\rogeecn\AceEditor\AceEditor::className(), [
    'mode'  => 'json',
    'theme' => 'github',
]) ?>

