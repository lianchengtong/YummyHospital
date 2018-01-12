<?php

/* @var $this \common\extend\View */
/* @var $content string */

/* @var $snip string */

use application\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= $this->commonMetaTags() ?>
    <?= Html::csrfMetaTags() ?>
    <title><?= \common\models\WebsiteConfig::getValueByKey("site.name") ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php require sprintf("%s/%s.php", __DIR__, $snip); ?>
<?php $this->endBody() ?>
<script>
    function msgTip(msg) {
        layer.open({
            content: msg,
            skin: "msg",
            time: 3
        });
    }

    function msgAlert(msg, btnTxt) {
        if (!btnTxt) {
            btnTxt = "好的";
        }
        layer.open({
            content: msg,
            btn: btnTxt
        });
    }

    function msgConfirm(msg, yesAction, noAction) {
        layer.open({
            content: msg,
            btn: ['取消', '确认'],
            yes: function (index) {
                noAction();
                layer.close(index);
            },
            no: function (index) {
                noAction();
                layer.close(index);
            }
        });
    }

    <?php
    if (!empty($this->errors)):
    $errMsg = Html::encode(implode('<br/>', $this->errors));
    ?>
    layer.open({
        content: "<?=$errMsg?>",
        skin: 'msg',
        time: 3
    });
    <?php endif;?>

</script>
</body>
</html>
<?php $this->endPage() ?>
