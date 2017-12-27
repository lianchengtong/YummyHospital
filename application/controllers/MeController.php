<?php

namespace application\controllers;


use application\base\BaseController;

class MeController extends BaseController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}