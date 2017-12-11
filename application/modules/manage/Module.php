<?php

namespace application\modules\manage;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'application\modules\manage\controllers';
    public $layout              = "@application/modules/manage/views/layouts/main";
    public $defaultRoute        = "login";

    public function init()
    {
        parent::init();
    }
}
