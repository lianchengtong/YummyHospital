<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */
/* @var $model common\models\PatientAsk */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>
            <?= sprintf("%s 咨询 %s",
                $model->patient->name,
                $model->doctor->name
            ) ?>
        </strong>
    </div>
    <div class="panel-body">
        <?= $model->description ?>
    </div>
    <div class="panel-images">
        <?php foreach ($model->getImageList() as $imageUrl): ?>
            <?= Html::img($imageUrl) ?>
        <?php endforeach; ?>
    </div>
    <div class="panel-body">

        <?= $form->field($model, 'reply')->textarea(['rows' => 6]) ?>
    </div>
    <div class="panel-footer">
        <?= Html::submitButton("提交回复", [
            'class' => 'btn btn-block btn-primary',
        ]) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

