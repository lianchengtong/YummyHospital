<?php

namespace application\controllers;

use application\base\BaseController;

class TestController extends BaseController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}