<?php
namespace application\controllers;

use application\base\BaseController;
use common\models\User;

class IndexController extends BaseController
{
    public function actionIndex()
    {
        return time();
    }
}
