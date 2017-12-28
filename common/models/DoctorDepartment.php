<?php

namespace common\models;

use common\utils\Cache;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "doctor_department".
 *
 * @property integer $id
 * @property integer $doctor_id
 * @property integer $department_id
 */
class DoctorDepartment extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public function rules()
    {
        return [
            [['doctor_id', 'department_id'], 'required'],
            [['doctor_id', 'department_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'doctor_id'     => 'Doctor ID',
            'department_id' => 'Department ID',
        ];
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    public static function getDepartmentID($doctorID)
    {
        $models = self::find()->where(['doctor_id' => $doctorID])->all();

        $ret = ArrayHelper::getColumn($models, "department_id");

        return $ret;
    }

    public static function getDepartmentList($doctorID)
    {
        $cacheKey = "doctor.department.list." . $doctorID;

        return Cache::dataProvider($cacheKey, function () use ($doctorID) {
            $models = self::find()->where(['doctor_id' => $doctorID])->with("department")->all();

            return ArrayHelper::map($models, "department_id", "department.name");
        });
    }

    public static function setDepartment($doctorID, $departmentIDList = [])
    {

        $cacheKey = "doctor.department.list." . $doctorID;
        Cache::delete($cacheKey);

        $currentDepartmentID = self::getDepartmentID($doctorID);
        $hasNew              = array_diff($departmentIDList, $currentDepartmentID);
        $hasDel              = array_diff($currentDepartmentID, $departmentIDList);

        if (0 == count($hasNew) && 0 == count($hasDel)) {
            return true;
        }

        self::deleteAll(['doctor_id' => $doctorID]);
        $dataList = [];
        foreach ($departmentIDList as $departmentID) {
            $dataList[] = [$doctorID, $departmentID];
        }

        return self::getDb()
                   ->createCommand()
                   ->batchInsert(self::tableName(), ["doctor_id", "department_id"], $dataList)
                   ->execute();
    }
}
