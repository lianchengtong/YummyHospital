<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\MemberOwnCard */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'original_money') ?>

    <?= $form->field($model, 'remain_money') ?>

    <?= $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'expire_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
</div>

<?php ActiveForm::end(); ?>

