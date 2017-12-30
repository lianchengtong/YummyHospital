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
            'user_id'     => 'User ID',
            'patient_id'  => 'Patient ID',
            'description' => 'Description',
            'images'      => 'Images',
            'reply'       => 'Reply',
            'reply_at'    => 'Reply At',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
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
