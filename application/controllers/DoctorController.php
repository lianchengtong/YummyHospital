<?php

namespace application\controllers;

use application\base\WebController;

class DoctorController extends WebController
{
    public $layoutSnip = "main";

    public function actionIndex()
    {
        return $this->render("index");
    }
}
