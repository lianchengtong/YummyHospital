<?php

namespace application\modules\manage\controllers;

use application\base\AuthController;
use common\utils\UserSession;

class LogoutController extends AuthController
{
    public function actionIndex()
    {
        UserSession::logout();

        return $this->redirect("/");
    }
}
