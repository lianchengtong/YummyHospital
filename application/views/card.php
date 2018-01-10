<?php
/** @var $model \common\models\MemberCard */
$this->title   = "我的会员卡";
$this->showTab = false;
?>
<?php if (!$model) { ?>
    <section class="ui-panel mt-20 mb-20">
        <div class="ui-panel-body ui-align-center pt-30 pb-30">
            <p>您还没有会员卡</p>
            <p class="mt-20">
                <?= \yii\helpers\Html::a("立即购买", ['card/index'], ['class' => 'ui-btn']) ?>
            </p>
        </div>
    </section>
<?php } else { ?>
    <section class="ui-panel mt-20 mb-20">
        <div class="ui-panel-heading ui-border-b">
            <span class="title"><?= $model->name ?></span>
            <span class="price">面值：&yen;<?= $model->price ?></span>
        </div>
        <div class="ui-panel-body">
            <div>
                <p class="buy-price">
                    购买价格：<?= $buyPrice ?>
                </p>
                <p class="buy-price">
                    消费折扣： <?= $model->discount ?>折
                </p>
            </div>
            <p class="ui-txt-info mt-20">
                <?= $model->description ?>
            </p>
        </div>
    </section>
<?php } ?>
