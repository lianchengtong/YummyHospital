<?php

namespace application\controllers;

use application\base\BaseController;

class AskController extends BaseController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
