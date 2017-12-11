<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\WebsiteConfigGroup */
/* @var $form yii\widgets\ActiveForm */

$this->title = '创建 Website Config Group';
$this->params['breadcrumbs'][] = ['label' => 'Website Config Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2><?=  Html::encode($this->title) ?></h2>
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
