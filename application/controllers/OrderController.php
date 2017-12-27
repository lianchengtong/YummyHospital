<?php

namespace application\controllers;

use application\base\WebController;

class OrderController extends WebController
{
    public $layoutSnip = "order_nav";

    public function actionIndex()
    {
        return $this->render("index");
    }
}
