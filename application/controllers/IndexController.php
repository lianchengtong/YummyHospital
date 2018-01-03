<?php

namespace application\controllers;

use application\base\WebAuthController;
use application\base\WebController;

class IndexController extends WebAuthController
{
    public function actionIndex()
    {
        return $this->output("page.index", [], [
            'title' => '首页',
            'showGoBack' => false,
        ]);
    }
}
