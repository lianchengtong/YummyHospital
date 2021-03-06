<?php

namespace common\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "doctor".
 *
 * @property integer                          $id
 * @property string                           $head_image
 * @property integer                          $level
 * @property integer                          $name
 * @property string                           $summary
 * @property integer                          $work_time
 * @property integer                          $type
 * @property string                           $introduce
 * @property string                           $rank
 * @property boolean                          $enable_ask
 * @property boolean                          $ask_price
 *
 * @property \common\models\DoctorServiceTime $doctorServiceTime
 * @property \common\models\DoctorLevel       $levelModel
 */
class Doctor extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;
    public    $department;
    public    $tag;

    const TYPE_DOCTOR = 0;
    const TYPE_LILIAO = 1;

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
            [['name'], 'required'],
            [['level', 'type', 'work_time', 'enable_ask', 'ask_price'], 'integer'],
            [['summary', 'name', 'introduce'], 'string'],
            [['head_image', 'rank', 'name'], 'string', 'max' => 255],
            [['department', 'tag'], 'safe'],
            [['ask_price'], 'default', 'value' => 20],
            [['enable_ask'], 'default', 'value' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'                             => 'ID',
            'head_image'                     => '头像',
            'level'                          => '职称',
            'name'                           => '姓名',
            'summary'                        => '简介',
            'work_time'                      => '工作年限',
            'introduce'                      => '医生介绍',
            'rank'                           => '星级',
            'doctorServiceTime.price'        => '挂号价格',
            'doctorServiceTime.ticket_count' => '号源数',
            'enable_ask'                     => '开通咨询功能',
            'ask_price'                      => '咨询价格',
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

        return parent::afterSave($insert, $changedAttributes);
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
            $tagIdList              = DoctorTag::getDoctorIDListByName($tagName);
            $departmentIDList       = Department::getLikeName($tagName);
            $doctorDepartmentIDList = DoctorDepartment::getByDepartmentIDList($departmentIDList);

            $idList    = array_filter(array_unique(array_merge($tagIdList, $doctorDepartmentIDList)));
            $condition = ['id' => $idList];
        }

        return self::find()->where($condition)->with('tags', 'levelModel', "departments")->all();
    }

    // 同科室医生列表

    /**
     * @param int $limit
     *
     * @return array|\yii\db\ActiveRecord[]|\common\models\Doctor[]
     */
    public function getSameDepartmentDoctors($limit = 5)
    {
        $doctorDepartment = $this->departments;
        $departmentID     = ArrayHelper::getColumn($doctorDepartment, "department_id");
        $departmentDoctor = DoctorDepartment::find()->where(['department_id' => $departmentID])->all();
        $doctorID         = ArrayHelper::getColumn($departmentDoctor, "doctor_id");

        shuffle($doctorID);
        $doctorIDGroup = array_chunk($doctorID, $limit);
        $doctors       = Doctor::find()->where(['id' => $doctorIDGroup[0]])->all();

        return $doctors;
    }

    public function departmentString()
    {
        $doctorDepartment = $this->departments;
        $departmentName   = [];
        foreach ($doctorDepartment as $departmentLinkModel) {
            $departmentName[] = $departmentLinkModel->department->name;
        }

        return implode(",", $departmentName);
    }

    public static function getTypeList()
    {
        return [
            self::TYPE_DOCTOR => '医生',
            self::TYPE_LILIAO => '理疗',
        ];
    }
}
