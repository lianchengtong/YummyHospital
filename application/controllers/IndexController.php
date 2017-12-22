<?php

namespace application\controllers;

use application\base\BaseController;

class IndexController extends BaseController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
