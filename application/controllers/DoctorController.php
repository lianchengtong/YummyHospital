<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Doctor;
use yii\web\NotFoundHttpException;

class DoctorController extends WebController
{
    public $layoutSnip = "main";

    public function actionIndex($id)
    {
        $model = Doctor::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $this->output("page.doctor",[
            'model'=>$model,
        ],['title'=>'医生详情']);
    }
}
