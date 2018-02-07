<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Address;
use common\utils\Json;
use common\utils\Request;
use common\utils\UserSession;
use yii\web\NotFoundHttpException;

class CoinController extends WebController
{
    public function actionIndex()
    {
        return $this->setViewData([
            'title' => '我的积分',
        ])->output("page.coin");
    }

    public function actionRule()
    {
        return $this->setViewData([
            'title' => '积分规则',
        ])->output("page.coin-rule");
    }
}
