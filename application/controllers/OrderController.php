<?php

namespace application\controllers;

use application\base\BaseController;

class OrderController extends BaseController
{
    public $layoutSnip = "order_nav";

    public function actionIndex()
    {
        return $this->render("index");
    }
}
