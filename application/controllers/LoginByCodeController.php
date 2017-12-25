<?php

namespace application\controllers;


use application\base\BaseController;

class LoginByCodeController extends BaseController
{
    public $layoutSnip = "main";

    public function actionIndex()
    {
        return $this->render('index');
    }
}