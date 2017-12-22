<?php

namespace application\controllers;

use application\base\BaseController;

class MyAppointmentController extends BaseController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
