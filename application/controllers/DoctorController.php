<?php

namespace application\controllers;

use application\base\BaseController;

class DoctorController extends BaseController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
