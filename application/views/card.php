<?php
/** @var $model \common\models\MemberCard */
?>

<?php
$userID = \common\utils\UserSession::getId();
foreach ($models as $model):
    $buyPrice = trim(sprintf("%0.2f", $model->price * $model->discount / 100), "0.");
    ?>
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
        <div class="ui-panel-body ui-align-right ui-border-t">
            <?php
            if (\common\models\MemberOwnCard::isUserHasCard($userID)) {
                $userCard = \common\models\MemberOwnCard::getUserEnableCard($userID);
                if ($userCard->memberCard->order > $model->order) {
                    echo \yii\helpers\Html::a("升级", ['card/buy', 'id' => $model->id], [
                        'class' => 'ui-btn-s ui-btn-primary',
                    ]);
                }
            } else {
                echo \yii\helpers\Html::a("购买", ['card/buy', 'id' => $model->id], [
                    'class' => 'ui-btn-s ui-btn-primary',
                ]);
            }
            ?>
        </div>
    </section>
<?php endforeach; ?>
