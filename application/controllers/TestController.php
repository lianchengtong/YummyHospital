<?php

namespace application\controllers;

use application\base\BaseController;
use common\models\DoctorServiceTime;
use common\models\WebsiteConfig;
use common\utils\Request;

class TestController extends BaseController
{
    public function actionIndex()
    {
        $id = Request::input("id");

        $model = new WebsiteConfig();
        return $this->render("index", [
            'html'  => DoctorServiceTime::calendar($id),
            'model' => $model,
        ]);
    }
}