<?php

namespace application\base;


use common\models\ManageUser;
use common\utils\UserSession;
use yii\web\ForbiddenHttpException;

trait TraitNeedLoginAdmin
{
    public function beforeAction($action)
    {
        if (UserSession::isGuest()) {
            UserSession::needLogin();

            return false;
        }

        if (!UserSession::isAdmin()) {
            $this->redirect('/');
            return false;
        }

        $moduleID = \Yii::$app->controller->module->id;
        if ($moduleID == "manage" && !ManageUser::getUser(UserSession::getId())) {
            throw new ForbiddenHttpException("need auth");
        }

        return parent::beforeAction($action);
    }
}