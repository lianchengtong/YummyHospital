<?php

namespace application\controllers;

use application\base\WebController;

class IndexController extends WebController
{
    public function actionIndex()
    {
        return $this->output("page.index", [], [
            'title'      => '首页',
            'showGoBack' => false,
        ]);
    }
}
