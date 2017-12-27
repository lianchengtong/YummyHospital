<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "patient_feedback".
 *
 * @property integer $id
 * @property integer $doctor_id
 * @property integer $appointment_id
 * @property string $mark
 * @property integer $content
 * @property integer $created_at
 * @property integer $updated_at
 */
class PatientFeedback extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doctor_id', 'appointment_id', 'mark', 'content', 'created_at', 'updated_at'], 'required'],
            [['doctor_id', 'appointment_id', 'content', 'created_at', 'updated_at'], 'integer'],
            [['mark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Doctor ID',
            'appointment_id' => 'Appointment ID',
            'mark' => 'Mark',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
