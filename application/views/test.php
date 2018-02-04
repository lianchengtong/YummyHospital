<?php
/** @var \common\models\Address $item */
?>
<div class="ui-page-address-list">
    <?php foreach ($list as $item): ?>
        <div class="ui-panel">
            <div class="ui-panel-heading ui-border-b">
                <span><?= $item->name ?></span>
                <span><?= $item->phone ?></span>
            </div>
            <div class="ui-panel-body">
                <div class="default">

                    <?php if ($item->default) { ?>
                        <button class="ui-btn-s ui-btn-primary action-set-default" data-id="<?= $item->id ?>">默认地址
                        </button>
                    <?php } else { ?>
                        <button class="ui-btn-s  action-set-default" data-id="<?= $item->id ?>">默认地址</button>
                    <?php } ?>
                </div>
                <div class="action-btn-list">
                    <button class="ui-btn-s">编辑</button>
                    <button class="ui-btn-s">删除</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="btn-wrapper">
        <a class="ui-btn-lg ui-btn-primary" href="<?=\yii\helpers\Url::to(["/address/create"])?>">添加新地址</a>
    </div>
</div>
