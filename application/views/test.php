
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
        <div class="ui-panel-body ui-align-right ui-border-t">
        </div>
    </section>
<?php endforeach; ?>