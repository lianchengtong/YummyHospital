<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        123123
    </div>
    <div class="panel-body">
        <?= \rogeecn\UnSlider\Slider::widget([
            'slides' => [
                [
                    'img'  => '/images/cat1.jpg',
                    'body' => 'Unslider widget for Yii2',
                    'url'  => "#",
                ],
                [
                    'img'   => '/images/cat2.jpg',
                    'title' => 'Another image',
                    'body'  => 'description',
                ],
            ]]);

        ?>
    </div>
    <div class="panel-footer">asdf</div>
</div>
