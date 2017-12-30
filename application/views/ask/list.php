<?php


/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\PatientAsk */

$this->title    = "我的咨询";
$this->showTab  = false;
$this->showSave = false;
?>


<?php foreach ($models as $model): ?>
    <section class="ui-panel mb-20 mt-20">
        <div class="ui-panel-heading">
            <div class="title"><?= $model->doctor->name ?></div>
            <div class="extend"><?= empty($model->reply_at) ? "等待回复" : "已回复" ?></div>
        </div>

        <div class="ui-panel-body ui-txt-info ui-txt-size-14">
            咨询：<?= \yii\helpers\Html::encode($model->description) ?>
        </div>

        <?php if (!empty($model->images)): ?>
            <div class="ui-panel-body">
                <ul class="image-list">
                    <?php foreach ($model->getImageList() as $imageUrl): ?>
                        <li>
                            <?= \yii\helpers\Html::img($imageUrl) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($model->reply_at)): ?>
            <div class="ui-panel-body ui-txt-info ui-txt-size-14">
                回复：<?= \yii\helpers\Html::encode($model->reply) ?>
            </div>
        <?php endif; ?>
    </section>
<?php endforeach; ?>
