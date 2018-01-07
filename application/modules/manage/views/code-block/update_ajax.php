<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CodeBlock */
/* @var $form yii\widgets\ActiveForm */

$this->title                   = '编辑代码段：' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Code Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>


<?php $form = ActiveForm::begin(['id'=>'form']); ?>
<div class="panel panel-default">
    <div class="panel-heading"><?=$model->name?></div>
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'form'  => $form,
        ]) ?>
    </div>
    <div class="panel-footer text-right">
        <?= Html::submitButton("提交", ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script>
    $(function(){
        $(document).on("beforeSubmit","#form",function () {
            var data  = $("#form").serialize();
            $.post($("#form").attr("action"),data,function(data){
                $("#code-container").html(data);
            });
            return false;
        });
    })

</script>
