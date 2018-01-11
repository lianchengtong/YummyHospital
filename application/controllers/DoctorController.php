<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Department;
use common\models\Doctor;
use common\models\DoctorAppointment;
use common\models\DoctorServiceTime;
use common\models\MyPatient;
use common\models\Order;
use common\models\OrderMontData;
use common\utils\Request;
use common\utils\UserSession;
use yii\web\NotFoundHttpException;

class DoctorController extends WebController
{
    public function actionIndex($id)
    {
        $this->layoutSnip = "main";

        /** @var Doctor $model */
        $model = Doctor::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $this->output("page.doctor", [
            'model' => $model,
        ], ['title' => '医生详情']);
    }

    public function actionAppointmentTerm()
    {
        return $this->output("page.doctor-appointment.term", [], [
            'title'   => '预约需知',
            'showTab' => false,
        ]);
    }

    /**
     * @deprecated
     *
     * @param $id
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionOrderDate($id)
    {
        /** @var Doctor $model */
        $model = Doctor::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $this->output("page.doctor-appointment.date-picker",
            ['model' => $model],
            [
                'title'   => '就诊日期',
                'showTab' => false,
            ]
        );
    }

    public function actionOrder($id)
    {
        /** @var Doctor $model */
        $doctorModel = Doctor::findOne($id);
        if (!$doctorModel) {
            throw new NotFoundHttpException();
        }

        $patientID    = Request::input("patient");
        $patientModel = MyPatient::getPatientModel($patientID, UserSession::getId());
        if (is_null($patientID)) {
            $patientID = $patientModel->id;
        }
        $departmentID = Request::input("department");
        $date         = Request::input("date");
        $time         = Request::input("time");

        $orderModel = new Order();
        if (Request::isPost()) {
            $trans = Order::getDb()->beginTransaction();
            try {
                list($year, $month, $day) = explode("-", $date);

                $patientModel = MyPatient::findOne($patientID);
                if (!$patientModel || $patientModel->user_id != UserSession::getId()) {
                    throw new \Exception("patient model not exist");
                }


                $doctorServiceDate = DoctorServiceTime::getAllRecentServiceTimeDate($doctorModel->id);
                if (!isset($doctorServiceDate[$date])) {
                    throw new \Exception("invalid doctor service datetime");
                }

                if ($doctorServiceDate[$date] <= 0) {
                    throw new \Exception("doctor has no ticket this day");
                }
                $departmentName = Department::getName($departmentID);

                $name  = sprintf("%s %s 医生 %s 会诊", $date, $doctorModel->name, $departmentName);
                $price = DoctorServiceTime::getDoctorServicePrice($doctorModel->id);
                $orderModel = Order::create(UserSession::getId(), $name, $price);
                if (!$orderModel) {
                    throw new \Exception("order create failed!");
                }
                $doctorServiceRange = DoctorServiceTime::getDateServiceRange($doctorModel->id, $date, false);

                $appointmentModel               = new DoctorAppointment();
                $appointmentModel->doctor_id    = $doctorModel->id;
                $appointmentModel->user_id      = UserSession::getId();
                $appointmentModel->patient_id   = $patientID;
                $appointmentModel->status       = DoctorAppointment::STATUS_PENDING;
                $appointmentModel->order_number = 1 + DoctorAppointment::getDayAppointmentCount($doctorModel->id, $year, $month, $day);
                list($appointmentModel->time_begin, $appointmentModel->time_end) = $doctorServiceRange;

                if (!$appointmentModel->save()) {
                    throw new \Exception("save appointment info fail");
                }

                $montData = OrderMontData::addData($orderModel->primaryKey, DoctorAppointment::rawTableName(), $appointmentModel->id);
                if ($montData !== true) {
                    throw new \Exception("order mont data save fail");
                }

                $montDataCallback = OrderMontData::getCallback(DoctorAppointment::className(), "callbackPaySuccess", [$appointmentModel->id]);
                $montData         = OrderMontData::addData($orderModel->primaryKey, "callback", $montDataCallback);
                if ($montData !== true) {
                    throw new \Exception("order mont data save fail");
                }


                $trans->commit();

                return $this->redirect(['/pay/index', 'id' => $orderModel->order_id]);
            } catch (\Exception $e) {
                $trans->rollBack();

                $errors[] = $e->getMessage();
            }
        }

        $params   = [
            'doctorModel'  => $doctorModel,
            'model'        => $orderModel,
            'patientModel' => $patientModel,
            'department'   => $departmentID,
            'date'         => $date,
            'time'         => $time,
            'userID'       => UserSession::getId(),
        ];
        $viewData = [
            'title'   => '确认订单',
            'showTab' => false,
            'errors'  => $errors,
        ];

        return $this->setViewData($viewData)->output("page.doctor-order", $params);
    }
}
