<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "doctor".
 *
 * @property integer $id
 * @property string $head_image
 * @property integer $level
 * @property integer $name
 * @property string $summary
 * @property integer $work_time
 * @property string $introduce
 * @property string $rank
 */
class Doctor extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'name', 'work_time'], 'integer'],
            [['name'], 'required'],
            [['summary', 'introduce'], 'string'],
            [['head_image', 'rank'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'head_image' => 'Head Image',
            'level' => 'Level',
            'name' => 'Name',
            'summary' => 'Summary',
            'work_time' => 'Work Time',
            'introduce' => 'Introduce',
            'rank' => 'Rank',
        ];
    }
}
