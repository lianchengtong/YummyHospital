<?php

namespace application\controllers;

use application\base\BaseController;

class PatientFormController extends BaseController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
