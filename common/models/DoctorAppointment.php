<?php

namespace common\models;

use common\utils\UserSession;

/**
 * This is the model class for table "doctor_appointment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $doctor_id
 * @property integer $time_begin
 * @property integer $time_end
 * @property integer $order_number
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class DoctorAppointment extends \common\base\ActiveRecord
{
    const STATUS_COMPLETE = 0;
    const STATUS_PENDING  = 1;
    const STATUS_CANCEL   = 2;
    const STATUS_BREAK    = 3;

    public static function getStatusDesc($id)
    {
        $list = self::getStatus();

        return $list[$id];
    }

    public static function getStatus()
    {
        return [
            self::STATUS_PENDING  => '进行中',
            self::STATUS_BREAK    => '已爽约',
            self::STATUS_CANCEL   => '已取消',
            self::STATUS_COMPLETE => '已完成',
        ];
    }

    public static function getDayAppointmentCount($doctorID, $year, $month, $day)
    {
        $timeBegin = strtotime(date(sprintf("%s-%s-%s", $year, $month, $day)));
        $timeEnd   = strtotime(date(sprintf("%s-%s-%s 23:59:59", $year, $month, $day)));

        $condition = [
            'and',
            [">", "time_begin", $timeBegin],
            ["<", "time_begin", $timeEnd],
            ["doctor_id" => $doctorID],

        ];
        return self::find()->where($condition)->count();
    }

    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'user_id'      => 'User ID',
            'doctor_id'    => 'Doctor ID',
            'time_begin'   => 'Time Begin',
            'time_end'     => 'Time End',
            'order_number' => 'Order Number',
            'status'       => 'Status',
            'created_at'   => 'Created At',
            'updated_at'   => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->user_id = UserSession::getId();
        }

        return parent::beforeSave($insert);
    }

    public function rules()
    {
        return [
            [['doctor_id', 'order_number', 'status'], 'required'],
            [['user_id', 'doctor_id', 'time_begin', 'time_end', 'order_number', 'status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    public function getPatientInfo()
    {
        return $this->hasOne(DoctorAppointmentPatientInfo::className(), ['appointment_id' => 'id']);
    }

}
