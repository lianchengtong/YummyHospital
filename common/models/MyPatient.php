<?php

namespace common\models;

/**
 * This is the model class for table "my_patient".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $name
 * @property integer $sex
 * @property string  $birth
 * @property string  $phone
 * @property string  $identify
 * @property integer $relation
 * @property integer $height
 * @property integer $weight
 * @property integer $is_self
 * @property integer $default
 */
class MyPatient extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public $birthYear;
    public $birthMonth;
    public $birthDay;

    public function rules()
    {
        return [
            [['user_id', 'name', 'sex', 'phone', 'identify'], 'required'],
            [['user_id', 'default', 'sex', 'height', 'is_self', 'weight', 'relation'], 'integer'],
            [['name', 'birth', 'phone', 'birth', 'identify'], 'string', 'max' => 255],
            [['birthYear', 'birthMonth', 'birthDay'], 'safe'],
            [['height', 'default', 'weight'], 'default', 'value' => 0],
            ['phone', 'match', 'pattern' => '/^1(3|4|5|7|8)\d{9}$/', "message" => "手机号码不合法"],
        ];
    }

    public function beforeValidate()
    {
        $this->birth = sprintf("%d-%d-%d", $this->birthYear, $this->birthMonth, $this->birthDay);
        if (!strtotime($this->birth)) {
            $this->addError("birthYear", "日期不合法");
        }

        if ($this->is_self) {
            if (empty($this->weight) || empty($this->height)) {
                $this->addError("user_id", "身高、体重不能为空！");
            }
        }

        if (!in_array(strlen($this->identify), [15, 18])) {
            $this->addError("user_id", "身份证号码不合法");
        }

        return parent::beforeValidate();
    }

    public function afterFind()
    {
        parent::afterFind();

        list($this->birthYear, $this->birthMonth, $this->birthDay) = explode("-", $this->birth);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'user_id'  => 'User ID',
            'name'     => '姓名',
            'sex'      => '性别',
            'birth'    => '生日',
            'phone'    => '手机号码',
            'identify' => '身份证号码',
        ];
    }

    public function getAge()
    {
        $deltaDate = date("Y") - $this->birthYear;

        return $deltaDate;
    }

    public function getSexDesc()
    {
        $list = ['女', '男'];

        return $list[$this->sex];

    }

    public static function getList($userID)
    {
        $models = self::getModelList($userID);

        $retData = [];
        foreach ($models as $model) {
            $retData[$model->id] = sprintf("%s, %s, %d岁",
                $model->name,
                $model->getSexDesc(),
                $model->getAge()
            );
        }

        return $retData;
    }

    /**
     * @param $userID
     *
     * @return array|\common\models\MyPatient[]|\yii\db\ActiveRecord[]
     */
    public static function getModelList($userID)
    {
        /** @var self[] $models */
        $models = self::find()->where(['user_id' => $userID])->all();

        return $models;
    }

    public static function relationList()
    {
        return [
            '本人',
            '家人',
            '亲属',
            '朋友',
        ];
    }

    public static function getPatientModel($patientID = null, $userID = null)
    {
        /** @var self $model */
        if (is_null($patientID)) {
            $model = self::find()->where(['default' => 1, 'user_id' => $userID])->one();
        } else {
            $model = self::find()->where(['id' => $patientID, 'user_id' => $userID])->one();
        }

        return $model;
    }

    public function getInfo()
    {
        return sprintf("%s, %s, %d岁",
            $this->name,
            $this->getSexDesc(),
            $this->getAge()
        );
    }

    public static function getPatient($patientID = null, $userID = null)
    {
        /** @var self $model */
        $model = self::getPatientModel($patientID, $userID);
        if (!$model) {
            return "&nbsp;";
        }

        return sprintf("%s, %s, %d岁",
            $model->name,
            $model->getSexDesc(),
            $model->getAge()
        );
    }

    public static function resetDefault($userID)
    {
        return self::updateAll(['default' => 0], ['user_id' => $userID]);
    }
}
