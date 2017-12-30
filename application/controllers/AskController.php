<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Doctor;
use common\models\PatientAsk;
use common\utils\Request;
use common\utils\UserSession;
use yii\web\ForbiddenHttpException;

class AskController extends WebController
{
    public function actionIndex($id)
    {
        $model = new PatientAsk();
        if (!Doctor::findOne($id)) {
            throw new ForbiddenHttpException();
        }
        $model->doctor_id = $id;
        $model->user_id   = UserSession::getId();

        if (Request::isPost() && $model->load(Request::input())) {
            if ($model->save()) {
                UserSession::setFlash("msg", "提交成功，请等待医师回复！");

                return $this->redirect(['list']);
            }
        }

        return $this->render("index", [
            'model' => $model,
        ]);
    }

    public function actionList()
    {
        $models = PatientAsk::getModelList(UserSession::getId());

        return $this->render("list", [
            'models' => $models,
        ]);
    }
}
