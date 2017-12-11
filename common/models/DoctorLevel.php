<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "doctor_level".
 *
 * @property integer $id
 * @property string $level_name
 */
class DoctorLevel extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level_name' => 'Level Name',
        ];
    }
}
