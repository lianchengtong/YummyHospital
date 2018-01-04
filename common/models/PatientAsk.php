<?php

namespace common\models;

/**
 * This is the model class for table "patient_ask".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $doctor_id
 * @property integer $patient_id
 * @property string  $description
 * @property string  $images
 * @property string  $reply
 * @property integer $reply_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class PatientAsk extends \common\base\ActiveRecord
{
    public function rules()
    {
        return [
            [['user_id', 'doctor_id', 'patient_id', 'description'], 'required'],
            [['user_id', 'patient_id', 'reply_at', 'created_at', 'updated_at'], 'integer'],
            [['description', 'images', 'reply'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'user_id'     => '用户',
            'patient_id'  => '患者',
            'description' => '描述',
            'images'      => '图片',
            'reply'       => '回复内容',
            'reply_at'    => '回复日期',
            'created_at'  => '创建日期',
            'updated_at'  => '更新日期',
        ];
    }

    public static function getModelList($userID)
    {
        $models = self::find()->where(['user_id' => $userID])->orderBy(['id' => SORT_DESC])->all();

        return $models;
    }

    public function getPatient()
    {
        return $this->hasOne(MyPatient::className(), ['id' => 'patient_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getImageList()
    {
        return array_filter(explode(",", $this->images));
    }
}
