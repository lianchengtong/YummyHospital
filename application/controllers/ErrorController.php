<?php

namespace application\controllers;

use application\base\BaseController;
use yii\web\Controller;

class ErrorController extends BaseController
{
    //public function actions()
    //{
    //    return [
    //        'index' => [
    //            'class' => 'common\extend\ErrorAction',
    //        ],
    //    ];
    //}

    public function actionIndex()
    {
        return $this->output("page.error", [], [
            'title' => '出错了',
            'showTab' => false,
        ]);
    }
}
