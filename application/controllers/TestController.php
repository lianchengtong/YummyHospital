<?php

namespace application\controllers;

use application\base\BaseController;
use common\models\WebsiteConfig;

class TestController extends BaseController
{
    public function actionIndex()
    {
        $model = new WebsiteConfig();
        return $this->render("index", [
            'model' => $model,
        ]);
    }
}