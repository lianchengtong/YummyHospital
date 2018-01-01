<?php

namespace application\controllers;


use application\base\WebController;
use common\utils\UserSession;

class MeController extends WebController
{
    public function actionIndex()
    {
        $params = [
            'model' => UserSession::identity(),
        ];

        return $this->output("page.me", $params, ['title' => '个人中心', 'showGoBack' => false]);
    }
}