<?php

namespace common\models;

/**
 * This is the model class for table "doctor_appointment_track".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $appointment_id
 * @property string  $track_message
 * @property integer $created_at
 * @property integer $updated_at
 */
class DoctorAppointmentTrack extends \common\base\ActiveRecord
{
    public function rules()
    {
        return [
            [['track_message'], 'trim'],
            [['track_message', 'user_id', 'appointment_id'], 'required'],
            [['user_id', 'appointment_id', 'created_at', 'updated_at'], 'integer'],
            [['track_message'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'user_id'        => '用户',
            'appointment_id' => '预约',
            'track_message'  => '跟踪消息',
            'created_at'     => '创建时间',
            'updated_at'     => '更新时间',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getCount($appointmentID)
    {
        return self::find()->where(['appointment_id' => $appointmentID])->count();
    }
}
