<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\MemberOwnCard */
/* @var $form yii\widgets\ActiveForm */

$this->title = '创建 Member Own Card';
$this->params['breadcrumbs'][] = ['label' => 'Member Own Cards', 'url' => ['index']];
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
