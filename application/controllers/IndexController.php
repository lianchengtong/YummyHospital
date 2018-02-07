<?php

namespace application\controllers;

use application\base\WebAuthController;

class IndexController extends WebAuthController
{
    public function actionIndex()
    {
        return $this->setViewData([
            'title'      => '首页',
            'showTab' => true,
            'showGoBack' => false,
        ])->output("page.index");
    }
}
