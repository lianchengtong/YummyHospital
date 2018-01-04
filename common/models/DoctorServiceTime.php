<?php

namespace common\models;

use common\extend\Html;
use common\utils\Cache;

/**
 * This is the model class for table "doctor_service_time".
 *
 * @property integer $id
 * @property integer $mode
 * @property integer $doctor_id
 * @property integer $price
 * @property integer $ticket_count
 * @property integer $max_time_long
 * @property array $month
 * @property array $week
 * @property array $week_service_start_at
 * @property array $day
 * @property array $am
 * @property array $pm
 */
class DoctorServiceTime extends \common\base\ActiveRecord
{
    const   MODE_WEEK = 0;
    const   MODE_MONTH = 1;

    protected $enableTimeBehavior = false;

    public static function weekDays()
    {
        return [1 => '一', '二', '三', '四', '五', '六', '日'];
    }

    public static function modeList()
    {
        return [
            self::MODE_WEEK => "周",
            self::MODE_MONTH => "月",
        ];
    }

    public static function monthList()
    {
        $items = range(1, 12);

        $newItems = [];
        foreach ($items as $item) {
            $newItems[] = $item . " 月";
        }

        return array_combine($items, $newItems);
    }

    public static function numberRange($begin, $end)
    {
        $step = 1;
        if ($begin < $end) {
            $step = -1;
        }

        $items = range($begin, $end, $step);

        return array_combine($items, $items);
    }

    public static function weekRange()
    {
        return ["每周", "隔周"];
    }

    public static function dayList($type = "month")
    {
        if ($type == "week") {
            $items = range(1, 7);

            return array_combine($items, self::weekDays());
        }
        $items = range(1, 31);

        return array_combine($items, $items);
    }

    public static function calendar($doctorID, $year, $month)
    {

        $headRows = Html::tag("tr", self::renderTableHead(self::weekDays()));
        $tableHead = Html::tag("thead", $headRows);

        $doctorServiceDay = self::getDoctorMonthServiceDays($doctorID, $year, $month);

        $bodyRows = Html::tag("tr", self::renderTableBody($doctorID, $doctorServiceDay, $year, $month));
        $tableBody = Html::tag("tbody", $bodyRows);

        $table = Html::tag("table", $tableHead . $tableBody, ['class' => 'table table-bordered text-center']);

        return $table;
    }

    private static function renderTableHead($items)
    {
        $headItems = [];
        foreach ($items as $item) {
            $headItems[] = Html::tag("td", $item);
        }

        return implode("\n", $headItems);
    }

    /**
     * 获取医生指定年月可服务日期
     *
     * @param $doctorID
     * @param $year
     * @param $month
     *
     * @return array
     */
    public static function getDoctorMonthServiceDays($doctorID, $year, $month)
    {
        $serviceDays = [];
        $serviceTimeModel = self::getByDoctorID($doctorID);
        if (!$serviceTimeModel) {
            return [];
        }

        if ($serviceTimeModel->mode == self::MODE_MONTH) {
            if (!in_array($month, $serviceTimeModel->month)) {
                return [];
            }

            $endDateYear = date("Y", strtotime(sprintf("+%d month", $serviceTimeModel->max_time_long)));
            $endDateMonth = date("n", strtotime(sprintf("+%d month", $serviceTimeModel->max_time_long)));
            if ($endDateYear == $year && $month > $endDateMonth) {
                return [];
            }

            $endDateDay = date("d", strtotime(sprintf("+%d month", $serviceTimeModel->max_time_long)));
            foreach ($serviceTimeModel->day as $monthDay) {
                if ($month == $endDateMonth && $monthDay > $endDateDay) {
                    break;
                }

                if ($month == $endDateMonth && !in_array($monthDay, $serviceTimeModel->day)) {
                    continue;
                }

                $appointmentCount = DoctorAppointment::getDayAppointmentCount($doctorID, $year, $month, $monthDay);
                $serviceDays[$monthDay] = $serviceTimeModel->ticket_count - $appointmentCount;
            }

            return $serviceDays;
        }

        $calTimestamp = strtotime(sprintf("%s-%s-1", $year, $month));
        $monthDays = range(1, date("t", $calTimestamp));

        $endDateYear = date("Y", strtotime(sprintf("+%d week", $serviceTimeModel->max_time_long)));
        $endDateMonth = date("n", strtotime(sprintf("+%d week", $serviceTimeModel->max_time_long)));
        if ($endDateYear == $year && $month > $endDateMonth) {
            return [];
        }
        $endDateDay = date("d", strtotime(sprintf("+%d week", $serviceTimeModel->max_time_long)));

        // 每周
        if ($serviceTimeModel->week == 0) {
            foreach ($monthDays as $monthDay) {
                if ($month == $endDateMonth && $monthDay > $endDateDay) {
                    break;
                }

                $dayWeekDay = date("N", strtotime(sprintf("%s-%s-%s", $year, $month, $monthDay)));
                if (!in_array($dayWeekDay, $serviceTimeModel->day)) {
                    continue;
                }

                $appointmentCount = DoctorAppointment::getDayAppointmentCount($doctorID, $year, $month, $monthDay);
                $serviceDays[$monthDay] = $serviceTimeModel->ticket_count - $appointmentCount;
            }

            return $serviceDays;
        }

        if ($serviceTimeModel->week == 1) {
            $beginTime = strtotime(sprintf("Y-m-d",
                $serviceTimeModel->week_service_start_at['year'],
                $serviceTimeModel->week_service_start_at['month'],
                $serviceTimeModel->week_service_start_at['day']
            ));

            $weekTimeLong = 7 * 24 * 60 * 60;
            foreach ($monthDays as $monthDay) {
                if ($month == $endDateMonth && $monthDay > $endDateDay) {
                    break;
                }

                $monthDayTimestamp = strtotime(sprintf("%s-%s-%s", $year, $month, $monthDay));
                if ((($monthDayTimestamp - $beginTime) / $weekTimeLong) % 2 != 0) {
                    continue;
                }

                $dayWeekDay = date("N", strtotime(sprintf("%s-%s-%s", $year, $month, $monthDay)));
                if (!in_array($dayWeekDay, $serviceTimeModel->day)) {
                    continue;
                }

                $appointmentCount = DoctorAppointment::getDayAppointmentCount($doctorID, $year, $month, $monthDay);
                $serviceDays[$monthDay] = $serviceTimeModel->ticket_count - $appointmentCount;
            }

            return $serviceDays;
        }
    }

    /**
     * @param $doctor_id
     *
     * @return array|null|\yii\db\ActiveRecord|\common\models\DoctorServiceTime
     */
    public static function getByDoctorID($doctor_id)
    {
        return Cache::model(self::className(), $doctor_id, function () use ($doctor_id) {
            $model = self::find()->where(['doctor_id' => $doctor_id])->one();

            return $model;
        });
    }

    private static function renderTableBody($doctorID, $doctorServiceDays, $year, $month)
    {
        $calTimestamp = strtotime(sprintf("%s-%s-1", $year, $month));
        $monthDays = range(1, date("t", $calTimestamp));

        if (($firstDayWeekID = date("N", $calTimestamp)) != 1) {
            $padPrefix = array_pad([], $firstDayWeekID - 1, 0);
            $monthDays = array_merge($padPrefix, $monthDays);
        }

        if ((count($monthDays) % 7) != 0) {
            $padSuffix = array_pad([], 7 - (count($monthDays) % 7), 0);
            $monthDays = array_merge($monthDays, $padSuffix);
        }

        $activeClass = ['class' => 'success', 'style' => 'vertical-align:middle'];
        $disableClass = ['class' => 'active', 'style' => 'vertical-align:middle'];
        $fullItems = [];
        $chunkFullMonthDays = array_chunk($monthDays, 7);
        $doctorServiceDayKey = array_keys($doctorServiceDays);
        foreach ($chunkFullMonthDays as $chunkWeekDays) {
            $rowItem = [];
            foreach ($chunkWeekDays as $monthDay) {
                if ($monthDay == 0) {
                    $rowItem[] = Html::tag("td", "&nbsp;");
                    continue;
                }

                if (in_array($monthDay, $doctorServiceDayKey)) {
                    $remainTicket = $doctorServiceDays[$monthDay];
                    $text = sprintf("%d<br>(剩余：%d)", $monthDay, $remainTicket);
                    if ($remainTicket == 0) {
                        $rowItem[] = Html::tag("td", $text, $activeClass);
                        continue;
                    }

                    $linkUrl = [
                        "/order",
                        'year' => $year,
                        'month' => $month,
                        'day' => $monthDay,
                        'doctor' => $doctorID,
                    ];
                    $orderLink = Html::a($text, $linkUrl, [
                        'style' => 'display:block;width:100%;height: 100%;text-decoration:none;color:#333;font-weight:bold;',
                    ]);
                    $rowItem[] = Html::tag("td", $orderLink, $activeClass);
                    continue;
                }
                $rowItem[] = Html::tag("td", $monthDay, $disableClass);
            }
            $fullItems[] = Html::tag("tr", implode("\n", $rowItem));
        }

        return implode("\n", $fullItems);
    }

    public function description()
    {
        return self::getDescription($this->doctor_id);
    }

    public static function getDescription($doctor_id)
    {
        $model = self::getByDoctorID($doctor_id);
        if (!$model) {
            return "无会诊信息";
        }

        $description = [];
        switch ($model->mode) {
            case self::MODE_MONTH:
                if (count($model->month) == 12) {
                    $description[] = "每月";
                } else {
                    $description[] = sprintf("%s月", implode("、", $model->month));
                }
                $description[] = implode("、", $model->day) . " 日";
                $description[] = sprintf("最长预约%d月内号源", $model->max_time_long);
                break;
            case self::MODE_WEEK:
                switch ($model->week) {
                    case 0;
                        $description[] = "每周";
                        break;
                    case 1;
                        $description[] = "隔周";
                        break;
                }
                $description[] = implode("、", self::convertToWeekDay($model->day));
                $description[] = sprintf("最长预约%d周内号源", $model->max_time_long);
                break;
        }

        if ($model->am['begin'] != $model->am['end']) {
            $description[] = sprintf("上午%s~%s", $model->am['begin'], $model->am['end']);
        }

        if ($model->pm['begin'] != $model->pm['end']) {
            $description[] = sprintf("下午%s~%s", $model->pm['begin'], $model->pm['end']);
        }

        return implode(" ", $description);
    }

    public static function convertToWeekDay($days)
    {
        $weekDayList = self::weekDays();
        $descDays = [];
        foreach ($days as $day) {
            $descDays[] = $weekDayList[$day];
        }

        return array_filter($descDays);
    }

    public function afterFind()
    {
        $this->week_service_start_at = json_decode($this->week_service_start_at, true);
        $this->month = json_decode($this->month, true);
        $this->day = json_decode($this->day, true);
        $this->am = json_decode($this->am, true);
        $this->pm = json_decode($this->pm, true);

        parent::afterFind();
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => '医生',
            'month' => '月',
            'week' => '周',
            'day' => '日',
            'am' => '上午',
            'pm' => '下午',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->mode == self::MODE_WEEK) {
            $this->day = json_encode($this->day['week']);
        } elseif ($this->mode == self::MODE_MONTH) {
            $this->day = json_encode($this->day['month']);
        }

        $this->week_service_start_at = json_encode($this->week_service_start_at);
        $this->month = json_encode($this->month);
        $this->am = json_encode($this->am);
        $this->pm = json_encode($this->pm);

        return parent::beforeSave($insert);
    }

    public function rules()
    {
        return [
            [['doctor_id', 'price', 'ticket_count', 'mode', 'max_time_long', 'am', 'pm'], 'required'],
            [['doctor_id', 'price', 'max_time_long', 'ticket_count'], 'integer'],
            [['week',], 'string', 'max' => 255],
            ['max_time_long', 'default', 'value' => 2],
            [['month', 'day', 'am', 'week_service_start_at', 'pm'], 'safe'],
        ];
    }

    // 获取医生所有可用号源天数
    public static function getAllRecentServiceTimeDate($doctorID)
    {
        $key = "doctor.all-recent-service-time-date-" . date("Ymd");

        return Cache::dataProvider($key, function () use ($doctorID) {
            $dateLimit = strtotime(sprintf("+%d days", self::getMaxTimeLong($doctorID)));
            $monthDelta = 0;
            $serviceDate = [];
            while (true) {
                $datetime = strtotime(sprintf("+%d month", $monthDelta));
                $monthDelta++;
                list($year, $month) = explode("-", date("Y-m", $datetime));
                $serviceDays = self::getDoctorMonthServiceDays($doctorID, $year, $month);

                if (empty($serviceDays)) {
                    break;
                }
                foreach ($serviceDays as $day => $ticketCount) {
                    if ($month == date("m") && $day < date("d")) {
                        continue;
                    }

                    $date = sprintf("%d-%d-%d", $year, $month, $day);
                    if (strtotime($date) > $dateLimit) {
                        break;
                    }
                    $serviceDate[$date] = $ticketCount;
                }

            }

            return $serviceDate;
        });
    }

    public static function getAllRecentServiceTimeDateList($doctorID, $withWeekDay = true)
    {
        $serviceDays = self::getAllRecentServiceTimeDate($doctorID);

        $retDay = [];
        foreach ($serviceDays as $serviceDate => $ticketCount) {
            list($year, $month, $serviceDay) = explode("-", $serviceDate);

            $dateCN = sprintf("%s年%d月%s日", $year, $month, $serviceDay);
            if ($withWeekDay) {
                $weekDay = date("N", strtotime($serviceDate));
                $weekDay = self::convertToWeekDay([$weekDay])[0];
                $dateCN .= " 周" . $weekDay;
            }
            $retDay[$serviceDate] = $dateCN;
        }

        return $retDay;
    }

    public static function getMaxTimeLong($doctorID)
    {
        $model = self::getByDoctorID($doctorID);

        return $model->max_time_long;
    }

    public static function getDoctorServicePrice($doctorID)
    {
        $model = self::getByDoctorID($doctorID);

        return $model->price;
    }

    public static function getDateServiceRange($doctorID, $date, $timestamp = true)
    {
        $model = self::getByDoctorID($doctorID);
        if ($model->am['begin'] != $model->am['end']) {
            $begin = sprintf("%s %d:00:00", $date, $model->am['begin']);
            $end = sprintf("%s %d:00:00", $date, $model->am['end']);
            if ($timestamp) {
                return [
                    strtotime($begin),
                    strtotime($end),
                ];
            }

            return [$begin, $end];
        }

        if ($model->pm['begin'] != $model->pm['end']) {
            $begin = sprintf("%s %d:00:00", $date, $model->pm['begin']);
            $end = sprintf("%s %d:00:00", $date, $model->pm['end']);

            if ($timestamp) {
                return [
                    strtotime($begin),
                    strtotime($end),
                ];
            }

            return [$begin, $end];
        }

        return [];
    }
}
