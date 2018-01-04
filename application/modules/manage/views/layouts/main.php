<?php

/* @var $this \common\extend\View */
/* @var $content string */

/* @var $snip string */

use yii\helpers\Html;

\application\assets\ManageAssets::register($this);
$this->isManageMode = true;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= $this->commonMetaTags() ?>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        body > .container-fluid {
            flex: 1;
            width: 100%;
        }

    </style>
</head>
<body>
<?php $this->beginBody() ?>
<?= $this->render("_nav") ?>
<?php require sprintf("%s/%s.php", __DIR__, $snip); ?>
<?= $this->render("_footer") ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

