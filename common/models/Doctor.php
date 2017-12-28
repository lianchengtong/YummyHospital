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
    public    $department;
    public    $tag;

    public function attributeHints()
    {
        return [
            'tag'        => '多个标签用逗号分割',
            'department' => '支持选择多个科室',
        ];
    }

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
            [['department', 'tag'], 'safe'],
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

    public function afterSave($insert, $changedAttributes)
    {
        if (!DoctorDepartment::setDepartment($this->id, $this->department)) {
            $this->addError('department', "科室添加错误");

            return false;
        }

        if (!DoctorTag::setTag($this->id, $this->tag)) {
            $this->addError('department', "标签添加错误");

            return false;
        }

        return parent::afterSave($insert);
    }

    public function getDoctorServiceTime()
    {
        return $this->hasOne(DoctorServiceTime::className(), [
            'doctor_id' => 'id',
        ]);
    }

    public function afterFind()
    {
        $this->department = DoctorDepartment::getDepartmentID($this->id);
        $this->tag        = implode(",", DoctorTag::getList($this->id));
        parent::afterFind();
    }

    public function getLevelModel()
    {
        return $this->hasOne(DoctorLevel::className(), ['id' => 'level']);
    }

    public function getDepartments()
    {
        return $this->hasMany(DoctorDepartment::className(), ['doctor_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(DoctorTag::className(), ['doctor_id' => 'id']);
    }

    public static function getByTag($tagName = "")
    {
        $condition = [];
        if (strlen($tagName)) {
            $idList    = DoctorTag::getDoctorIDListByName($tagName);
            $condition = ['id' => $idList];
        }

        return self::find()->where($condition)->with('tags', 'levelModel', "departments")->all();
    }
}
