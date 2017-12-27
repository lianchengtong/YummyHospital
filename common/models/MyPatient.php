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
 */
class MyPatient extends \common\base\ActiveRecord
{
    public $birthYear;
    public $birthMonth;
    public $birthDay;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'my_patient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'sex', 'birth', 'phone', 'identify'], 'required'],
            [['user_id', 'sex'], 'integer'],
            [['name', 'birth', 'phone', 'identify'], 'string', 'max' => 255],
            [['birthYear', 'birthMonth', 'birthDay'], 'safe'],
        ];
    }

    public function beforeValidate()
    {
        $this->birth = sprintf("%d-%d-%d", $this->birthYear, $this->birthMonth, $this->birthDay);
        if (!strtotime($this->birth)) {
            $this->addError("birthYear", "日期不合法");
        }

        parent::beforeValidate();
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
}
