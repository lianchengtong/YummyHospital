<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "doctor_appointment_track".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $appointment_id
 * @property string $track_message
 * @property integer $created_at
 * @property integer $updated_at
 */
class DoctorAppointmentTrack extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor_appointment_track';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'appointment_id'], 'required'],
            [['user_id', 'appointment_id', 'created_at', 'updated_at'], 'integer'],
            [['track_message'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'appointment_id' => 'Appointment ID',
            'track_message' => 'Track Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
