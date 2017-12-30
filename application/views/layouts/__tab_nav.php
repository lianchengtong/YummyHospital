<?php


/** @var string $content */
/** @var \common\extend\View $this */
?>

<?php if ($this->showTab): ?>
    <?= \application\builder\Code::output("element.tabbar") ?>
<?php endif; ?>

<?php if ($this->showNav): ?>
    <?= \application\builder\Code::output("element.navbar") ?>
<?php endif; ?>

<section class="ui-container">
    <?= $content ?>
</section>
