<?php

namespace application\controllers;

use application\base\BaseController;
use application\builder\Code;
use common\models\WebsiteConfig;

class TestController extends BaseController
{
    public function actionIndex()
    {
        $content = Code::get("bottom.col-1");
        return $this->renderContent($content);

        $model = new WebsiteConfig();
        return $this->render("index", [
            'model' => $model,
        ]);
    }
}