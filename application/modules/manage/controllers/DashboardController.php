<?php

namespace application\modules\manage\controllers;

use application\base\AuthController;
use common\utils\UserSession;

class DashboardController extends AuthController
{
    public function actionIndex()
    {
        return $this->render([
            'message' => 'hello world!',
        ]);
    }
}
