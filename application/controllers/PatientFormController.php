<?php

namespace application\controllers;

use application\base\WebController;

class PatientFormController extends WebController
{
    public $layoutSnip = "nav";

    public function actionIndex()
    {
        return $this->render("index");
    }
}
