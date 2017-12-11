<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "doctor_service_time".
 *
 * @property integer $id
 * @property integer $docker_id
 * @property string $month
 * @property string $day
 * @property string $am
 * @property string $pm
 */
class DoctorServiceTime extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor_service_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['docker_id', 'month', 'day', 'am', 'pm'], 'required'],
            [['docker_id'], 'integer'],
            [['month', 'day', 'am', 'pm'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'docker_id' => 'Docker ID',
            'month' => 'Month',
            'day' => 'Day',
            'am' => 'Am',
            'pm' => 'Pm',
        ];
    }
}
