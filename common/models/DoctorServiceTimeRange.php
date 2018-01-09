<?php

namespace common\models;

/**
 * This is the model class for table "doctor_service_time_range".
 *
 * @property int    $id
 * @property int    $doctor_id
 * @property string $begin
 * @property string $end
 * @property int    $count
 */
class DoctorServiceTimeRange extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public function rules()
    {
        return [
            [['doctor_id', 'begin', 'end', 'count'], 'required'],
            [['doctor_id', 'count'], 'integer'],
            [['begin', 'end'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'doctor_id' => 'Doctor ID',
            'begin'     => 'Begin',
            'end'       => 'End',
            'count'     => 'Count',
        ];
    }

    public static function clearForDoctor($doctorID)
    {
        return self::deleteAll(['doctor_id' => $doctorID]);
    }

    public static function saveForDoctor($doctorID, $timeRange)
    {
        self::clearForDoctor($doctorID);

        $timeRange = strtr($timeRange, [
            "：" => ":",
        ]);

        $timeRangeArr = explode("\n", trim($timeRange));
        foreach ($timeRangeArr as $timeRageString) {
            list($timeRange, $count) = explode("|", trim($timeRageString));
            list($timeBegin, $timeEnd) = explode("-", $timeRange);

            $model = new DoctorServiceTimeRange();
            $model->setAttributes([
                'doctor_id' => $doctorID,
                'begin'     => $timeBegin,
                'end'       => $timeEnd,
                'count'     => intval($count),
            ]);
            $model->save();
        }
    }

    public static function getStringForDoctor($doctorID)
    {
        $models = self::find()->where(['doctor_id' => $doctorID])->orderBy(['id' => SORT_ASC])->all();

        $dataList = [];
        foreach ($models as $model) {
            $dataList[] = sprintf("%s-%s|%d", $model->begin, $model->end, $model->count);
        }

        return implode("\n", $dataList);
    }

    public static function getList($doctorID, $date)
    {
        /** @var self[] $models */
        $models = self::find()->where(['doctor_id' => $doctorID])->all();

        list($year, $month, $day) = explode("-", $date);

        $list = [];
        foreach ($models as $model) {
            list($beginHour, $beginMin) = explode(":", $model->begin);
            list($endHour, $endMin) = explode(":", $model->end);

            $beginTime = strtotime(sprintf("%d-%02d-%02d %02d:%02d:00", $year, $month, $day, $beginHour, $beginMin));
            $endTime   = strtotime(sprintf("%d-%02d-%02d %02d:%02d:00", $year, $month, $day, $endHour, $endMin));

            $appointmentCount = DoctorAppointment::getDayTimeAppointmentCount($doctorID, $beginTime, $endTime);
            $list[]           = [
                'time'  => sprintf("%s~%s", $model->begin, $model->end),
                'count' => $model->count - $appointmentCount,
            ];
        }

        return $list;
    }
}
