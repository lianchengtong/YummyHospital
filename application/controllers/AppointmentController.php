<?php

namespace application\controllers;

use application\base\WebController;
use common\models\DoctorAppointment;
use common\models\PatientFeedback;
use common\utils\Request;
use common\utils\UserSession;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class AppointmentController extends WebController
{
    public function actionIndex()
    {
        $tagName = \common\utils\Request::input("tag");
        $items   = \common\utils\Cache::dataProvider(
            "page.doctor-appointment-list-" . $tagName,
            function () use ($tagName) {
                return \common\models\Doctor::getByTag($tagName);
            }
        );

        $viewSettings = [
            'title'      => "门诊预约",
            'showGoBack' => false,
        ];

        return $this->output("page.doctor-appointment-list", [
            'items' => $items,
        ], $viewSettings);
    }

    // 我的预约
    public function actionMine()
    {
        $models = DoctorAppointment::find()
                                   ->where(['user_id' => UserSession::getId()])
                                   ->orderBy(['id' => SORT_DESC])
                                   ->all();

        return $this->render("mine", [
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

        $params = [
            'models' => $feedbackModels,
        ];

        return $this->output("page.appointment.feedback-list", $params, [
            'title'   => '我的评价',
            'showTab' => false,
        ]);
    }
}
