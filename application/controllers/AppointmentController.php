<?php

namespace application\controllers;

use application\base\BaseController;

class AppointmentController extends BaseController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
