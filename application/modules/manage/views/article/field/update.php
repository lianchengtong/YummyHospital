<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleTypeField */
/* @var $form yii\widgets\ActiveForm */

$this->title = '编辑字段' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Article Type Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>


<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading">
    </div>
    <div class="panel-body">
        <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
        ]) ?>
    </div>
    <div class="panel-footer text-right">
        <?=  Html::submitButton("提交", ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
