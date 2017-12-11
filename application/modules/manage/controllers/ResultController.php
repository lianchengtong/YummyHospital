<?php

namespace application\modules\manage\controllers;

use application\base\AuthController;

class ResultController extends AuthController
{
    public function actionSuccess()
    {
        return $this->render("success");
    }

    public function actionFail()
    {
        return $this->render("fail");
    }
}
