<?php

namespace application\controllers;


use application\base\WebController;
use common\utils\UserSession;

class LogoutController extends WebController
{
    public function actionIndex()
    {
        UserSession::logout();

        return $this->redirect("/");
    }
}