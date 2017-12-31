<?php

namespace application\controllers;


use application\base\WebController;

class MeController extends WebController
{
    public function actionIndex()
    {
        return $this->output("page.me", [], ['title' => '个人中心', 'showGoBack' => false]);
    }
}