<?php

namespace application\modules\manage\controllers;

use application\base\AuthController;

class ManagerController extends AuthController
{
    public function actionIndex()
    {
        return $this->render([
            'message' => 'hello world!',
        ]);
    }
}
