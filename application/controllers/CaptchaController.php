<?php

namespace application\controllers;

use application\base\BaseController;
use application\base\WebController;
use common\extend\CaptchaAction;
use yii\web\Controller;

class CaptchaController extends BaseController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => CaptchaAction::className(),
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'height' => 24,
                'minLength' => 4,
                'maxLength' => 4,
            ],
        ];
    }
}
