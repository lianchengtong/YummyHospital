<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>
<div class="container-fluid global-container">
    <div class="row">
        <div class="col-md-12">
            <h1 style="margin: 0 0 30px 0"><?= Html::encode($this->title) ?></h1>
            <?= $content ?>
        </div>
    </div>
</div>
