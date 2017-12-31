<?php

namespace application\controllers;

use application\base\WebController;
use common\models\Doctor;
use common\models\DoctorDepartment;
use common\models\Order;
use common\utils\Json;
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

        return $this->render("/order", [
            'doctorModel' => $doctorModel,
            'model'       => (new Order()),
        ]);
    }
}
