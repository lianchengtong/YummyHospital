<?php


/** @var string $content */
/** @var \common\extend\View $this */
?>

<?= \application\builder\Code::output("element.tabbar") ?>
<?= \application\builder\Code::output("element.navbar") ?>

<section class="ui-container">
    <?= $content ?>
</section>
