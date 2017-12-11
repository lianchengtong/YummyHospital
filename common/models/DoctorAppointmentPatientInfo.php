<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "doctor_appointment_patient_info".
 *
 * @property integer $id
 * @property integer $appointment_id
 * @property string $username
 * @property string $phone
 * @property string $memo
 */
class DoctorAppointmentPatientInfo extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor_appointment_patient_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appointment_id', 'username'], 'required'],
            [['appointment_id'], 'integer'],
            [['memo'], 'string'],
            [['username', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
            'username' => 'Username',
            'phone' => 'Phone',
            'memo' => 'Memo',
        ];
    }
}
