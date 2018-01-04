<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Doctor;
use common\models\PatientAsk;
use common\utils\Request;
use common\utils\Session;
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
        $model->user_id = UserSession::getId();

        if (Request::isPost() && $model->load(Request::input())) {
            if ($model->save()) {
                return $this->redirect(['list']);
            }
        }


        return $this->setViewData([
            'title' => "门诊预约",
        ])->output("page.patient-ask-form", [
            'model' => $model,
        ]);
    }

    public function actionList()
    {
        $models = PatientAsk::getModelList(UserSession::getId());

        return $this->setViewData([
            'title' => "我的咨询",
        ])->output("page.my-ask-history-list", [
            'models' => $models,
        ]);
    }
}
