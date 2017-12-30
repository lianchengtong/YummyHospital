<?php

namespace application\controllers;

use application\base\WebController;
use common\models\MyPatient;
use common\utils\Request;
use common\utils\UserSession;
use yii\web\NotFoundHttpException;

class PatientController extends WebController
{
    public function actionIndex()
    {
        $models = MyPatient::getModelList(UserSession::getId());

        return $this->render("index", [
            'models' => $models,
        ]);
    }

    public function actionCreate()
    {
        $model          = new MyPatient();
        $model->user_id = UserSession::getId();

        if (Request::isPost() && $model->load(Request::input())) {
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render("form", [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model          = MyPatient::findOne($id);
        $model->user_id = UserSession::getId();

        if (!$model) {
            throw new NotFoundHttpException();
        }

        if (Request::isPost() && $model->load(Request::input())) {
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render("form", [
            'model' => $model,
        ]);
    }
}
