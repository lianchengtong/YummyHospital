<?php

namespace application\controllers;


use application\base\WebController;

class MeController extends WebController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}