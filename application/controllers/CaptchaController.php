<?php
namespace application\controllers;

use application\base\WebController;
use common\extend\CaptchaAction;

class CaptchaController extends WebController
{
    public function actions()
    {
        return [
            'index' => [
                'class'           => CaptchaAction::className(),
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'height'          => 24,
                'minLength'       => 4,
                'maxLength'       => 4,
            ],
        ];
    }
}
