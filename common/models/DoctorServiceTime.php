<?php

namespace common\models;

/**
 * This is the model class for table "doctor_service_time".
 *
 * @property integer $id
 * @property integer $doctor_id
 * @property string  $month
 * @property string  $week
 * @property string  $day
 * @property string  $am
 * @property string  $pm
 */
class DoctorServiceTime extends \common\base\ActiveRecord
{
    public static function modeList()
    {
        return ["周", "月"];
    }

    public static function monthList()
    {
        $items = range(1, 12);

        $newItems = [];
        foreach ($items as $item) {
            $newItems[] = $item . " 月";
        }
        return $newItems;
    }

    public static function clockRange($begin, $end)
    {
        $step = 1;
        if ($begin < $end) {
            $step = -1;
        }
        return range($begin, $end, $step);
    }

    public static function weekRange()
    {
        return ["每周", "隔周"];
    }

    public function dayList($type = "month")
    {
        if ($type == "week") {
            return range(1, 7);
        }
        return range(1, 31);
    }

    public function rules()
    {
        return [
            [['doctor_id', 'max_time_long', 'week', 'model', 'month', 'day', 'am', 'pm'], 'required'],
            [['doctor_id', 'max_time_long'], 'integer'],
            [['month', 'day', 'am', 'pm'], 'string', 'max' => 255],
            ['max_time_long', 'default', 'value' => 2],
        ];
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
}
