<?php

namespace common\models;

use common\utils\Cache;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "doctor_level".
 *
 * @property integer $id
 * @property string  $level_name
 */
class DoctorLevel extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public function rules()
    {
        return [
            [['level_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'level_name' => '名称',
        ];
    }

    public static function levelList()
    {
        return Cache::getOrSet("doctor.level.list", function () {
            $models = self::find()->all();

            return ArrayHelper::map($models, 'id', 'level_name');
        });
    }

    public static function levelDesc($id)
    {
        $list = self::levelList();

        return $list[$id];
    }
}
