<?php

namespace application\controllers;

use application\base\WebController;
use common\models\DoctorAppointment;
use common\models\PatientFeedback;
use common\models\UserCoin;
use common\utils\Request;
use common\utils\UserSession;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class AppointmentController extends WebController
{
    public function actionAskShow()
    {
        $this->hackMode = true;

        return $this->setViewData([
            'showGoBack' => false,
            'showTab'    => true,
            'title'      => '理疗预约',
        ])->output("page.ask-show");
    }

    public function actionCancel()
    {
        return $this->setViewData([
            'title' => '我的预约',
        ])->output("page.appointment.cancel");
    }

    public function actionAsk()
    {
        $departmentName = \common\utils\Request::input("department");
        $items          = \common\utils\Cache::getOrSet(
            "page.doctor-appointment-list-" . $departmentName,
            function () use ($departmentName) {
                return \common\models\Doctor::getByTag($departmentName);
            }
        );

        return $this->setViewData([
            'title'      => "在线问诊",
            'showGoBack' => false,
        ])->output("page.doctor-appointment-ask-list", [
            'items' => $items,
        ]);
    }

    public function actionList()
    {
        $tagName = \common\utils\Request::input("tag");
        $items   = \common\utils\Cache::getOrSet(
            "page.doctor-appointment-list-" . $tagName,
            function () use ($tagName) {
                return \common\models\Doctor::getByTag($tagName);
            }
        );

        return $this->setViewData([
            'title'      => "门诊预约",
            'showGoBack' => false,
            'showTab'    => true,
        ])->output("page.appointment.list", [
            'items' => $items,
        ]);
    }

    // 我的预约
    public function actionMine()
    {
        $models = DoctorAppointment::find()
                                   ->where(['user_id' => UserSession::getId()])
                                   ->orderBy(['id' => SORT_DESC])
                                   ->all();

        return $this->setViewData([
            'title'      => '我的预约',
            'showGoBack' => false,
        ])->output("page.appointment.mine", [
            'models' => $models,
        ]);
    }

    public function actionFeedback($id)
    {
        $appointmentModel = DoctorAppointment::findOne($id);
        if (!$appointmentModel) {
            throw new NotFoundHttpException();
        }

        if ($appointmentModel->feedback) {
            throw new NotFoundHttpException();
        }

        $feedbackModel = new PatientFeedback();
        if (Request::isPost() && $feedbackModel->load(Request::input())) {
            $feedbackModel->doctor_id      = $appointmentModel->doctor_id;
            $feedbackModel->appointment_id = $appointmentModel->id;

            if ($feedbackModel->save()) {
                UserCoin::feedbackGain(UserSession::getId());

                return $this->redirect(['mine']);
            }
            $this->getView()->errors = $feedbackModel->getErrorList();
        }

        $params = [
            'model'            => $feedbackModel,
            'appointmentModel' => $appointmentModel,
        ];

        return $this->output("page.appointment.feedback-form", $params, [
            'title'   => '就诊评价',
            'showTab' => false,
        ]);
    }

    public function actionFeedbackList()
    {
        $condition         = ['user_id' => UserSession::getId()];
        $appointmentModels = DoctorAppointment::find()->select("id")->where($condition)->all();
        $appointmentID     = ArrayHelper::getColumn($appointmentModels, "id");
        $feedbackModels    = PatientFeedback::find()
                                            ->where(['appointment_id' => $appointmentID])
                                            ->orderBy(['id' => SORT_DESC])
                                            ->all();


        return $this->setViewData([
            'title'   => '我的评价',
            'showTab' => false,
        ])->output("page.appointment.feedback-list", [
            'models' => $feedbackModels,
        ]);
    }
}
