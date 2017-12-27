<?php

namespace application\controllers;

use application\base\WebController;

class ProfileController extends WebController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
