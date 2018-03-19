<?php

namespace application\modules\manage\controllers;

use application\base\BaseController;
use application\modules\manage\forms\LoginForm;
use common\utils\Request;
use common\utils\UserSession;

class LoginController extends BaseController
{
    public function actionIndex()
    {
        if (!UserSession::isGuest()) {
            return $this->redirect("/manage/dashboard");
        }

        $model = new LoginForm();
        if ($model->load(Request::post()) && $model->login()) {
            return $this->redirect("/manage/dashboard");
        }

        return $this->render([
            'model' => $model,
        ]);
    }
}
