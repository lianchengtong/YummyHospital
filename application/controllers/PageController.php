<?php

namespace application\controllers;

use application\base\BaseController;

class PageController extends BaseController
{
    public $layoutSnip = "page";

    public function actionIndex()
    {
        return $this->render("index");
    }
}
