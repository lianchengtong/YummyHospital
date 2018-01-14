<?php

namespace application\controllers;

use application\base\WebController;
use common\models\MyPatient;
use common\utils\Json;
use common\utils\Request;
use common\utils\UserSession;
use yii\web\NotFoundHttpException;

class PatientController extends WebController
{
    public function actionIndex()
    {
        $mode   = Request::input("mode", "show");
        $models = MyPatient::getModelList(UserSession::getId());

        $codeID = "page.patient-list-mode-select";
        if ($mode == "show") {
            $codeID = "page.patient-list-mode-show";
        }

        return $this->output($codeID, [
            'models' => $models,
            'from'   => Request::input("from", "ask"),
        ], ['title' => '就诊人管理']);
    }

    public function actionSetDefault($id)
    {
        $model = MyPatient::findOne($id);
        if (!$model || $model->user_id != UserSession::getId()) {
            throw new NotFoundHttpException();
        }
        if ($model->default == 1) {
            return Json::success();
        }

        MyPatient::resetDefault($model->user_id);

        $model->default = 1;
        if ($model->save(false)) {
            return Json::success();
        }

        return Json::error($model->getErrors());
    }

    public function actionDelete($id)
    {
        $model = MyPatient::findOne($id);
        if (!$model || $model->user_id != UserSession::getId()) {
            throw new NotFoundHttpException();
        }

        return Json::error($model->delete());
    }

    public function actionMe()
    {
        $model = MyPatient::findOne(['is_self' => 1, 'user_id' => UserSession::getId()]);
        if (!$model) {
            $model = new MyPatient();
        }
        if ($model->isNewRecord && Request::isPost() && $model->load(Request::input())) {
            $model->is_self = true;
            $model->default = 1;
            $model->user_id = UserSession::getId();
            if ($model->save()) {
                $this->redirect("/me");
            }
            $this->getView()->errors = $model->getErrorList();
        }

        return $this->setViewData([
            'showSave' => $model->isNewRecord,
            'showTab'  => false,
            'title'    => '个人资料',
        ])->output("page.patient-me", [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model          = new MyPatient();
        $model->user_id = UserSession::getId();
        $mode           = Request::input("mode", "show");

        if (Request::isPost() && $model->load(Request::input())) {
            if ($model->save()) {
                return $this->redirect([
                    'index',
                    "id"      => Request::input("id"),
                    "patient" => Request::input("patient"),
                    "mode"    => $mode,
                ]);
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
