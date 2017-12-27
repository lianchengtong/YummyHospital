<?php

namespace application\controllers;

use application\base\WebController;

class AppointmentController extends WebController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
