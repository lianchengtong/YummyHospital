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
            [['user_id', 'sex', 'height', 'is_self', 'weight', 'relation'], 'integer'],
            [['name', 'birth', 'phone', 'birth', 'identify'], 'string', 'max' => 255],
            [['birthYear', 'birthMonth', 'birthDay'], 'safe'],
        ];
    }

    public function beforeValidate()
    {
        $this->birth = sprintf("%d-%d-%d", $this->birthYear, $this->birthMonth, $this->birthDay);
        if (!strtotime($this->birth)) {
            $this->addError("birthYear", "日期不合法");
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
}
