<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Doctor;
use common\models\DoctorAppointment;
use common\models\Order;
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
        return $this->setViewData([
            'showGoBack' => false,
            'showTab'    => true,
            'title'      => '在线问诊',
        ])->output("page.ask-show");
    }

    public function actionCancel()
    {
        return $this->setViewData([
            'title' => '我的预约',
        ])->output("page.appointment.cancel");
    }

    public function actionCancelOrder($id)
    {
        $model = DoctorAppointment::findOne($id);
        //if (!$model || $model->user_id != UserSession::getId() || $model->status != DoctorAppointment::STATUS_PENDING) {
        //    throw new NotFoundHttpException();
        //}

        $trans = \Yii::$app->getDb()->beginTransaction();
        try {
            $model->status = DoctorAppointment::STATUS_CANCEL;
            if (!$model->save(false)) {
                throw new \Exception("cancel faild");
            }

            $orderModel = $model->getOrder();
            if ($orderModel) {
                if ($orderModel == Order::STATUS_PAY_SUCCESS) {
                    $orderModel->status = Order::STATUS_PAY_REFUND;
                }

                if ($orderModel == Order::STATUS_PENDING_PAY) {
                    $orderModel->status = Order::STATUS_PAY_CLOSED;
                }
                if (!$orderModel->save(false)) {
                    var_dump($orderModel->getErrors());
                    exit;
                    throw new \Exception(json_encode($model->getErrors()));
                }
            }

            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollBack();
        }

        return $this->redirect(['/appointment/mine']);
    }

    public function actionAsk()
    {
        $department = \common\utils\Request::input("department", "");
        $items      = \common\models\Doctor::getByTag($department);
        $order      = \common\utils\Request::input("order", "default");

        if ($order != "default") {
            $markMap = [];
            $itemMap = [];
            foreach ($items as $item) {
                $markMap[$item->id] = \common\models\PatientFeedback::getDoctorMark($item->id);
                $itemMap[$item->id] = $item;
            }
            arsort($markMap);

            $items = [];
            foreach ($markMap as $id => $markItem) {
                $items[] = $itemMap[$id];
            }
        }

        return $this->setViewData([
            'title'      => "在线问诊",
            'showGoBack' => false,
        ])->output("page.doctor-appointment-ask-list", [
            'items'             => $items,
            'currentDepartment' => $department,
        ]);
    }

    public function actionList()
    {
        $department = \common\utils\Request::input("department");
        $items      = \common\models\Doctor::getByTag($department);
        $order      = \common\utils\Request::input("order", "default");

        if ($order != "default") {
            $markMap = [];
            $itemMap = [];
            foreach ($items as $item) {
                $markMap[$item->id] = \common\models\PatientFeedback::getDoctorMark($item->id);
                $itemMap[$item->id] = $item;
            }
            arsort($markMap);

            $items = [];
            foreach ($markMap as $id => $markItem) {
                $items[] = $itemMap[$id];
            }
        }


        return $this->setViewData([
            'title'      => "门诊预约",
            'showGoBack' => false,
            'showTab'    => true,
        ])->output("page.appointment.list", [
            'items'             => $items,
            'currentDepartment' => $department,
        ]);
    }

    public function actionAgain()
    {
        $ids = DoctorAppointment::find()->select("doctor_id")->where([
            'user_id' => UserSession::getId(),
        ]);

        $items = Doctor::find()->where(['id' => $ids])->all();

        return $this->setViewData([
            'title'      => "一键复诊",
            'showGoBack' => false,
            'showTab'    => true,
        ])->output("page.appointment.list", [
            'items' => $items,
        ]);
    }

    public function actionDetail($id)
    {
        $model = DoctorAppointment::findOne($id);
        if (!$model || $model->user_id != UserSession::getId()) {
            throw new NotFoundHttpException();
        }

        return $this->setViewData([
            'title' => '预约详情',
        ])->output("page.appointment-detail", [
            'model' => $model,
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
            'title' => '我的预约',
        ])->output("page.appointment.mine", [
            'models' => $models,
        ]);
    }

    // 我未评价的预约
    public function actionPendingFeedback()
    {
        $condition = [
            'user_id'     => UserSession::getId(),
            'status'      => DoctorAppointment::STATUS_COMPLETE,
            'feedback_at' => 0,
        ];
        $models    = DoctorAppointment::find()
                                      ->where($condition)
                                      ->orderBy(['id' => SORT_DESC])
                                      ->all();

        return $this->setViewData([
            'title' => '待评论',
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
