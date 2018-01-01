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

        return $this->output("page.patient-list", [
            'models' => $models,
        ], ['title' => '就诊人管理']);
    }

    public function actionMe()
    {
        $model = MyPatient::findOne(['is_self' => 1, 'user_id' => UserSession::getId()]);
        if (!$model) {
            $model = new MyPatient();
        }
        if ($model->isNewRecord && Request::isPost() && $model->load(Request::input())) {
            $model->is_self = true;
            $model->user_id = UserSession::getId();
            if ($model->save()) {
                $this->redirect("/me");
            }
            $this->getView()->errors = $model->getErrorList();
        }

        return $this->render("me", [
            'model' => $model,
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

        $params = [
            'model' => $model,
        ];

        return $this->output("page.patient-create-update-form", $params, [
            'title'    => "就诊人",
            'showTab'  => false,
            'showSave' => true,
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

        $params = [
            'model' => $model,
        ];

        return $this->output("page.patient-create-update-form", $params, [
            'title'    => "就诊人",
            'showTab'  => false,
            'showSave' => true,
        ]);
    }
}
