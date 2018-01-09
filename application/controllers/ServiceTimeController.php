<?php

namespace application\controllers;

use application\base\WebController;
use application\builder\Code;
use common\models\DoctorServiceTimeRange;
use common\utils\Request;

class ServiceTimeController extends WebController
{
    public function actionTimeRange()
    {
        $doctorID = Request::input("doctor");
        $datetime = Request::input("date");

        $timeRange = DoctorServiceTimeRange::getList($doctorID, $datetime);

        return Code::output("element.doctor-service-time-range", [
            'timeRange' => $timeRange,
            'date'      => $datetime,
            'doctor'    => $doctorID,
        ]);
    }
}
