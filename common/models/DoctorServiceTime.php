<?php

namespace common\models;

/**
 * This is the model class for table "doctor_service_time".
 *
 * @property integer $id
 * @property integer $mode
 * @property integer $doctor_id
 * @property integer $max_time_long
 * @property string  $month
 * @property string  $week
 * @property string  $day
 * @property string  $am
 * @property string  $pm
 */
class DoctorServiceTime extends \common\base\ActiveRecord
{
    const MODE_WEEK  = 0;
    const MODE_MONTH = 1;

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
        } else {
            $items = range(1, 31);
        }

        return array_combine($items, $items);
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

    public function afterFind()
    {
        $this->month = json_decode($this->month, true);
        $this->day   = json_decode($this->day, true);
        $this->am    = json_decode($this->am, true);
        $this->pm    = json_decode($this->pm, true);

        parent::afterFind();
    }

    public function rules()
    {
        return [
            [['doctor_id', 'mode', 'max_time_long', 'am', 'pm'], 'required'],
            [['doctor_id', 'max_time_long'], 'integer'],
            [['week'], 'string', 'max' => 255],
            ['max_time_long', 'default', 'value' => 2],
            [['month', 'day', 'am', 'pm'], 'safe'],
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
