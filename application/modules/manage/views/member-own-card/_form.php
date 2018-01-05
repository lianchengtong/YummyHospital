<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MemberOwnCard */
?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'original_money')->textInput() ?>

    <?= $form->field($model, 'remain_money')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'expire_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>


