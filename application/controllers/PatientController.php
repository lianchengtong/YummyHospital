<?php

namespace application\controllers;

use application\base\BaseController;

class PatientController extends BaseController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
