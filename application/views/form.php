<div class="ui-form ui-border-t">
    <?php $form = \yii\widgets\ActiveForm::begin([
        'options' => [
            'id' => 'form',
        ],
    ]) ?>
    <div class="ui-form-item ui-border-b">
        <label>真实姓名</label>
        <?= \yii\helpers\Html::activeTextInput($model, "name", [
            'placeholder' => '真实姓名',
        ]) ?>
    </div>

    <div class="ui-form-item ui-border-b">
        <label>性别</label>
        <div class="ui-select">
            <?= \yii\helpers\Html::activeDropDownList($model, "sex", ['女', '男']) ?>
        </div>
    </div>


    <div class="ui-form-item ui-border-b">
        <label>手机号</label>
        <?= \yii\helpers\Html::activeTextInput($model, "phone", [
            'placeholder' => '联系手机号',
        ]) ?>
    </div>

    <div class="ui-form-item ui-border-b">
        <label>成员关系</label>
        <div class="ui-select">
            <?= \yii\helpers\Html::activeDropDownList($model, "relation", \common\models\MyPatient::relationList()); ?>
        </div>
    </div>

    <div class="ui-form-item ui-border-b">
        <label>生日</label>
        <div class="ui-select-group">
            <div class="ui-select">
                <?= \yii\helpers\Html::activeDropDownList($model, "birthYear", \common\utils\ListGenerator::year()) ?>
            </div>
            <div class="ui-select">
                <?= \yii\helpers\Html::activeDropDownList($model, "birthMonth", \common\utils\ListGenerator::month()) ?>
            </div>
            <div class="ui-select">
                <?= \yii\helpers\Html::activeDropDownList($model, "birthDay", \common\utils\ListGenerator::day()) ?>
            </div>
        </div>
    </div>


    <div class="ui-form-item ui-border-b">
        <label>身份证号</label>
        <?= \yii\helpers\Html::activeTextInput($model, "identify", [
            'pattern' => '\d*', 'placeholder' => "18或15位身份证号", 'type' => 'tel',
        ]) ?>
    </div>


    <div class="ui-form-item ui-border-b">
        <label>身高</label>
        <?= \yii\helpers\Html::activeTextInput($model, "height", [
            'pattern' => '\d*', 'placeholder' => "厘米", 'type' => 'tel',
        ]) ?>
    </div>

    <div class="ui-form-item ui-border-b">
        <label>体重</label>
        <?= \yii\helpers\Html::activeTextInput($model, "weight", [
            'pattern' => '\d*', 'placeholder' => "千克", 'type' => 'tel',
        ]) ?>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>

