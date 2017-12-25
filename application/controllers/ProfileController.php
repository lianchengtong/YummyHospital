<?php

namespace application\controllers;

use application\base\BaseController;

class ProfileController extends BaseController
{
    public function actionIndex()
    {
        return $this->render("index");
    }
}
