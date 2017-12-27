<?php

namespace application\controllers;


use application\base\WebController;
use common\models\DoctorServiceTime;
use common\utils\Request;

class ServiceCalendarController extends WebController
{
    public function actionIndex()
    {
        $currentYear  = date("Y");
        $currentMonth = date("n");

        $id    = Request::input("id");
        $year  = Request::input("year", $currentYear);
        $month = Request::input("month", $currentMonth);

        if ($year < $currentYear) {
            $year = $currentYear;
        }

        if ($year == $currentYear && $month < $currentMonth) {
            $month = $currentMonth;
        }

        $showPrevLink = false;
        if ($year >= $currentYear) {
            if ($year > $currentYear) {
                $showPrevLink = true;
            } else {
                if ($month > $currentMonth) {
                    $showPrevLink = true;
                }
            }
        }

        $selectTimestamp = strtotime(date(sprintf("%s-%s-1", $year, $month)));

        $prevMonth = date("Y-n", strtotime("-1 month", $selectTimestamp));
        $nextMonth = date("Y-n", strtotime("+1 month", $selectTimestamp));

        $prevMonth = array_combine(['year', 'month'], explode("-", $prevMonth));
        $nextMonth = array_combine(['year', 'month'], explode("-", $nextMonth));


        return $this->render("index", [
            'currentMonth' => sprintf("%s年%s月", $year, $month),
            'calendarHtml' => DoctorServiceTime::calendar($id, $year, $month),
            'nextMonth'    => $nextMonth,
            'prevMonth'    => $prevMonth,
            'showPrevLink' => $showPrevLink,
            'doctorID'     => $id,
        ]);
    }
}