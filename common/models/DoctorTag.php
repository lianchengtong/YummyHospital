<?php

namespace common\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "doctor_tag".
 *
 * @property integer $id
 * @property string  $doctor_id
 * @property string  $name
 */
class DoctorTag extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public function rules()
    {
        return [
            [['doctor_id', 'name'], 'required'],
            [['doctor_id', 'name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'doctor_id' => 'Doctor ID',
            'name'      => 'Name',
        ];
    }

    public static function getList($doctorID)
    {
        $models = self::find()->where(['doctor_id' => $doctorID])->all();

        return ArrayHelper::getColumn($models, "name");
    }

    public static function setTag($doctorID, $tag)
    {
        $tag  = strtr($tag, [
            "，"  => ',',
            "\n" => ',',
            " "  => '',
        ]);
        $tags = array_filter(array_unique(explode(",", $tag)));

        $currentTagList = self::getList($doctorID);
        $hasDel         = array_diff($currentTagList, $tags);
        $hasNew         = array_diff($tags, $currentTagList);

        if (0 == count($hasDel) && 0 == count($hasNew)) {
            return true;
        }

        self::deleteAll(['doctor_id' => $doctorID]);

        $dataList = [];
        foreach ($tags as $tag) {
            $dataList[] = [$doctorID, trim($tag)];
        }

        return self::getDb()
                   ->createCommand()
                   ->batchInsert(self::tableName(), ["doctor_id", "name"], $dataList)
                   ->execute();

    }
}
