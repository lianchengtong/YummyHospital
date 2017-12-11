<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

$this->title = <?= $generator->generateString('创建 ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= "<?php " ?>$form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2><?= "<?= " ?> Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">
        <?= "<?= " ?>$this->render('_form', [
            'model' => $model,
            'form' => $form,
        ]) ?>
    </div>
    <div class="panel-footer text-right">
        <?= "<?= " ?> Html::submitButton("提交", ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?= "<?php " ?>ActiveForm::end(); ?>
