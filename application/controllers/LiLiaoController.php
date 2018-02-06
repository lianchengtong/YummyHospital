<?php

namespace application\controllers;

use application\base\WebController;

class LiLiaoController extends WebController
{
    public function actionList()
    {
        return $this->setViewData([
            'title' => '理疗预约',
        ])->output("page.liliao");
    }
}
