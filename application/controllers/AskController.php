<?php

namespace application\controllers;

use application\base\WebController;

class AskController extends WebController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
