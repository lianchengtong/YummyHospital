<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\ArticleType */
/* @var $form yii\widgets\ActiveForm */

$this->title = '创建 Article Type';
$this->params['breadcrumbs'][] = ['label' => 'Article Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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