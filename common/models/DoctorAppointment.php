<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "doctor_appointment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $docker_id
 * @property integer $time_begin
 * @property integer $time_end
 * @property integer $order_number
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class DoctorAppointment extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor_appointment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'docker_id', 'order_number', 'status'], 'required'],
            [['user_id', 'docker_id', 'time_begin', 'time_end', 'order_number', 'status', 'created_at', 'updated_at'], 'integer'],
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
            'docker_id' => 'Docker ID',
            'time_begin' => 'Time Begin',
            'time_end' => 'Time End',
            'order_number' => 'Order Number',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
