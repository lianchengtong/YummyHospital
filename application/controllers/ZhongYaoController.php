<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Address;
use common\utils\Json;
use common\utils\Request;
use common\utils\UserSession;
use yii\web\NotFoundHttpException;

class ZhongYaoController extends WebController
{
    public function actionIndex()
    {
        $this->hackMode = true;
        return $this->setViewData([
            'title' => '品质中药',
        ])->output("page.zhongyao");
    }
}
