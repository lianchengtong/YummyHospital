<?php

namespace application\controllers;

use application\base\WebController;

class PatientController extends WebController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
