<?php

namespace common\models;

/**
 * This is the model class for table "doctor_appointment_patient_info".
 *
 * @property integer $id
 * @property integer $appointment_id
 * @property string  $username
 * @property string  $phone
 * @property string  $memo
 */
class DoctorAppointmentPatientInfo extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = FALSE;

    public function rules()
    {
        return [
            [['appointment_id', 'username'], 'required'],
            [['appointment_id'], 'integer'],
            [['memo'], 'string'],
            [['username', 'phone'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'appointment_id' => '预约',
            'username'       => '用户名',
            'phone'          => '电话',
            'memo'           => '备注',
        ];
    }
}
