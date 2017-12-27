<?php

namespace application\modules\manage\controllers;

use application\base\AuthController;
use common\utils\Request;
use yii\helpers\FileHelper;

class CacheController extends AuthController
{
    public function actionClear()
    {
        $cacheDirs = [
            \Yii::getAlias("@runtime/cache"),
        ];
        foreach ($cacheDirs as $cacheDir) {
            FileHelper::removeDirectory($cacheDir);
        }

        $returnTo = Request::input("__return");
        if (!empty($returnTo)) {
            return $this->redirect($returnTo);
        }

        return $this->redirect(['@admin/dashboard']);
    }
}
