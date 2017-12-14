<?php

namespace application\modules\wechat\controllers;

use application\base\WeChatWebBaseController;

class WebController extends WeChatWebBaseController
{
    public function actionIndex()
    {
        return $this->redirect(['callback']);
    }

    public function actionCallback()
    {
        return "hello!";
    }
}
