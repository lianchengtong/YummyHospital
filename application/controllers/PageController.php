<?php

namespace application\controllers;

use application\base\WebController;

class PageController extends WebController
{
    public $layoutSnip = "page";

    public function actionIndex()
    {
        return $this->render("index");
    }
}
