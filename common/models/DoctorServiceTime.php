<?php

namespace common\models;

use common\extend\Html;

/**
 * This is the model class for table "doctor_service_time".
 *
 * @property integer $id
 * @property integer $mode
 * @property integer $doctor_id
 * @property integer $ticket_count
 * @property integer $max_time_long
 * @property string  $month
 * @property string  $week
 * @property string  $day
 * @property string  $am
 * @property string  $pm
 */
class DoctorServiceTime extends \common\base\ActiveRecord
{
    const   MODE_WEEK  = 0;
    const   MODE_MONTH = 1;
    const   WEEK_DAY   = [1 => '一', '二', '三', '四', '五', '六', '日'];

    protected $enableTimeBehavior = false;

    public static function modeList()
    {
        return [
            self::MODE_WEEK  => "周",
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

    public static function clockRange($begin, $end)
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
            return array_combine($items, self::WEEK_DAY);
        }
        $items = range(1, 31);
        return array_combine($items, $items);
    }

    public static function calendar($doctorID, $year = 2017, $month = 12)
    {
        $html = [];

        $headRows  = Html::tag("tr", self::renderTableHead(self::WEEK_DAY));
        $tableHead = Html::tag("thead", $headRows);

        $bodyRows    = Html::tag("tr", self::renderTableBody($year, $month));
        $tableBody   = Html::tag("tbody", $bodyRows);
        $table       = Html::tag("table", $tableHead . $tableBody, ['class' => 'table table-bordered']);
        $panelHead   = Html::tag("div", "Head", ['class' => 'panel-heading']);
        $panelFooter = Html::tag("div", "Footer", ['class' => 'panel-footer']);
        $html        = Html::tag("div", $panelHead . $table . $panelFooter, ['class' => 'panel panel-default']);
        return $html;
    }

    private static function renderTableHead($items)
    {
        $headItems = [];
        foreach ($items as $item) {
            $headItems[] = Html::tag("th", $item);
        }
        return implode("\n", $headItems);
    }

    private static function renderTableBody($year, $month)
    {
        $month        = 11;
        $calTimestamp = strtotime(sprintf("%s-%s-1", $year, $month));
        $monthDays    = range(1, date("t", $calTimestamp));

        if (($firstDayWeekID = date("w", $calTimestamp)) != 1) {
            $firstDayWeekID = self::convertWeekToMondayFirst($firstDayWeekID);
            $padPrefix      = array_pad([], $firstDayWeekID - 1, 0);
            $monthDays      = array_merge($padPrefix, $monthDays);
        }

        if ((count($monthDays) % 7) != 0) {
            $padSuffix = array_pad([], count($monthDays) % 7 - 1, 0);
            $monthDays = array_merge($monthDays, $padSuffix);
        }

        $fullItems          = [];
        $chunkFullMonthDays = array_chunk($monthDays, 7);
        foreach ($chunkFullMonthDays as $chunkWeekDays) {
            $rowItem = [];
            foreach ($chunkWeekDays as $monthDay) {
                if ($monthDay == 0) {
                    $rowItem[] = Html::tag("td", "&nbsp;");
                    continue;
                }

                $rowItem[] = Html::tag("td", $monthDay);
            }
            $fullItems[] = Html::tag("tr", implode("\n", $rowItem));
        }
        return implode("\n", $fullItems);
    }

    private static function convertWeekToMondayFirst($weekday)
    {
        $map = [
            0 => 6,
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 7,
        ];
        return $map[$weekday];
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

    /**
     * @param $doctor_id
     *
     * @return array|null|\yii\db\ActiveRecord|\common\models\DoctorServiceTime
     */
    public static function getByDoctorID($doctor_id)
    {
        $model = self::find()->where(['doctor_id' => $doctor_id])->one();
        return $model;
    }

    public static function convertToWeekDay($days)
    {
        $descDays = [];
        foreach ($days as $day) {
            $descDays[] = self::WEEK_DAY[$day];
        }
        return array_filter($descDays);
    }

    public function afterFind()
    {
        $this->month = json_decode($this->month, true);
        $this->day   = json_decode($this->day, true);
        $this->am    = json_decode($this->am, true);
        $this->pm    = json_decode($this->pm, true);

        parent::afterFind();
    }

    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'doctor_id' => 'Doctor ID',
            'month'     => 'Month',
            'week'      => 'Week',
            'day'       => 'Day',
            'am'        => 'Am',
            'pm'        => 'Pm',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->mode == self::MODE_WEEK) {
            $this->day = json_encode($this->day['week']);
        } elseif ($this->mode == self::MODE_MONTH) {
            $this->day = json_encode($this->day['month']);
        }

        $this->month = json_encode($this->month);
        $this->am    = json_encode($this->am);
        $this->pm    = json_encode($this->pm);

        return parent::beforeSave($insert);
    }

    public function rules()
    {
        return [
            [['doctor_id', 'ticket_count', 'mode', 'max_time_long', 'am', 'pm'], 'required'],
            [['doctor_id', 'max_time_long', 'ticket_count'], 'integer'],
            [['week'], 'string', 'max' => 255],
            ['max_time_long', 'default', 'value' => 2],
            [['month', 'day', 'am', 'pm'], 'safe'],
        ];
    }
}
