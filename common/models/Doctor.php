<?php

namespace common\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "doctor".
 *
 * @property integer $id
 * @property string  $head_image
 * @property integer $level
 * @property integer $name
 * @property string  $summary
 * @property integer $work_time
 * @property string  $introduce
 * @property string  $rank
 */
class Doctor extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public static function getList()
    {
        $model = self::find()->all();

        return ArrayHelper::map($model, 'id', 'name');
    }

    public function rules()
    {
        return [
            [['level', 'work_time'], 'integer'],
            [['name'], 'required'],
            [['summary', 'name', 'introduce'], 'string'],
            [['head_image', 'rank', 'name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'head_image' => '头像',
            'level'      => '职称',
            'name'       => '姓名',
            'summary'    => '简介',
            'work_time'  => '工作年限',
            'introduce'  => '医生介绍',
            'rank'       => '星级',
        ];
    }

    public function getDoctorServiceTime()
    {
        return $this->hasOne(DoctorServiceTime::className(), [
            'doctor_id' => 'id',
        ]);
    }
}
