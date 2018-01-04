<?php

namespace common\models;

/**
 * This is the model class for table "patient_feedback".
 *
 * @property integer $id
 * @property integer $doctor_id
 * @property integer $appointment_id
 * @property integer $mark
 * @property string  $content
 * @property integer $created_at
 * @property integer $updated_at
 */
class PatientFeedback extends \common\base\ActiveRecord
{
    public function rules()
    {
        return [
            [['doctor_id', 'appointment_id', 'mark', 'content'], 'required'],
            [['doctor_id', 'appointment_id', 'mark', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'doctor_id'      => '医生',
            'appointment_id' => '预约',
            'mark'           => '评分',
            'content'        => '内容',
            'created_at'     => '创建日期',
            'updated_at'     => '更新日期',
        ];
    }

    public function getAppointment()
    {
        return $this->hasOne(DoctorAppointment::className(), ['id' => 'appointment_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    public static function getLatestFeedbackToDoctor($doctorID)
    {
        return self::find()
                   ->where(['doctor_id' => $doctorID])
                   ->with("appointment")
                   ->orderBy(['id' => SORT_DESC])
                   ->one();
    }

    public function maskPatientName()
    {
        $name  = $this->appointment->patientInfo->name;
        $len   = mb_strlen($name, "utf8");
        $first = mb_substr($name, 0, 1, 'utf8');

        return $first . str_pad("*", $len);
    }
}
