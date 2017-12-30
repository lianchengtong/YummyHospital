<?php

use yii\helpers\Html;

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title = "门诊预约";

$items = \common\models\MyPatient::getList(\common\utils\UserSession::getId());
?>

<?php $form = \yii\widgets\ActiveForm::begin(); ?>
<div class="row ui-form ui-border-t pb-20">
    <div class="ui-form-item ui-border-b">
        <label>就诊人</label>
        <div class="ui-select">
            <?= Html::activeDropDownList($model, "patient_id", $items) ?>
        </div>
    </div>

    <div class="ui-row-container mt-20 mb-20">
        <label class="ui-block">病情描述</label>
        <div class="ui-block-textarea-wrapper">
            <?= Html::activeTextarea($model, "description", [
                'class'       => 'ui-block-textarea',
                'rows'        => 5,
                'placeholder' => "请对您的病情进行描述",
            ]) ?>
        </div>
    </div>

    <div class="ui-row-container mt-20 mb-20">
        <?= \rogeecn\SimpleAjaxUploader\MultipleImage::widget([
            'model'             => $model,
            'attribute'         => 'images',
            'style'             => false,
            'uploadIconOptions' => [
                'class' => 'ui-icon-add',
            ],
        ]) ?>
        <p class="ui-txt-muted">
            请上传您的舌苔照、病历部位、病历、处方单、检查图片等诊断材料。
        </p>
    </div>
</div>

<div class="ui-btn-wrap mt-20">
    <input type="submit" value="确定" class="ui-btn-lg ui-btn-primary"/>
</div>
<?php \yii\widgets\ActiveForm::end() ?>

<?php print_r($model->getErrors())?>
