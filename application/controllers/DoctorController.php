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

        $orderModel = new Order();
        if (Request::isPost()) {
            $data  = Request::input("data");
            $trans = Order::getDb()->beginTransaction();
            try {
                $patientID  = $data['patient'];
                $doctorID   = $data['doctor_id'];
                $department = $data['department'];
                $date       = $data['date'];
                $payChannel = $data['pay_channel'];
                list($year, $month, $day) = explode("-", $date);

                $patientModel = MyPatient::findOne($patientID);
                if (!$patientModel || $patientModel->user_id != UserSession::getId()) {
                    throw new \Exception("patient model not exist");
                }


                $payChannelList = Order::getPayChannel();
                if (!isset($payChannelList[$payChannel])) {
                    throw new \Exception("pay channel not exist!");
                }

                $doctorServiceDate = DoctorServiceTime::getAllRecentServiceTimeDate($doctorID);
                if (!isset($doctorServiceDate[$date])) {
                    throw new \Exception("invalid doctor service datetime");
                }

                if ($doctorServiceDate[$date] <= 0) {
                    throw new \Exception("doctor has no ticket this day");
                }
                $departmentName = Department::getName($department);

                $name  = sprintf("%s %s 医生 %s 会诊", $date, $doctorModel->name, $departmentName);
                $price = DoctorServiceTime::getDoctorServicePrice($doctorID);
                $order = Order::create($payChannel, $name, $price);
                if (!$order) {
                    throw new \Exception("order create faild!");
                }
                $doctorServiceRange = DoctorServiceTime::getDateServiceRange($doctorID, $date, false);

                $appointmentModel               = new DoctorAppointment();
                $appointmentModel->doctor_id    = $doctorID;
                $appointmentModel->user_id      = UserSession::getId();
                $appointmentModel->patient_id   = $patientID;
                $appointmentModel->status       = DoctorAppointment::STATUS_PENDING;
                $appointmentModel->order_number = 1 + DoctorAppointment::getDayAppointmentCount($doctorID, $year, $month, $day);
                list($appointmentModel->time_begin, $appointmentModel->time_end) = $doctorServiceRange;

                if (!$appointmentModel->save()) {
                    throw new \Exception("save appoint ment info fail");
                }

                $orderMontDataModel           = new OrderMontData();
                $orderMontDataModel->order_id = $order->primaryKey;
                $orderMontDataModel->name     = 'appointment_id';
                $orderMontDataModel->content  = strval($appointmentModel->id);
                if (!$orderMontDataModel->save()) {
                    throw new \Exception("order mont data save fail");
                }


                $trans->commit();

                return $this->redirect(['/order/wechat-pay', 'id' => $order->order_id]);
            } catch (\Exception $e) {
                $trans->rollBack();
            }
        }

        $params = [
            'doctorModel' => $doctorModel,
            'model'       => $orderModel,
        ];

        return $this->output("page.order", $params, [
            'title'   => '确认订单',
            'showTab' => false,
        ]);
    }
}
