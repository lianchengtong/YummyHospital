<?php

namespace application\controllers;

use application\base\WebController;

class MyAppointmentController extends WebController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
