<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sms_history".
 *
 * @property integer $id
 * @property string  $phone
 * @property integer $success
 * @property string  $data
 * @property integer $created_at
 */
class SmsHistory extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = true;

    public static function addMessage($phone, $isSuccess = false, $data = "")
    {
        $model = new self();
        $model->setAttributes([
            'phone'   => $phone,
            'success' => $isSuccess,
            'data'    => json_encode($data),
        ]);

        return $model->save();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'phone'      => 'Phone',
            'success'    => 'Success',
            'data'       => 'Data',
            'created_at' => 'Created At',
        ];
    }

    public function behaviors()
    {
        $behaviors   = [];
        $behaviors[] = [
            'class'      => TimestampBehavior::className(),
            'attributes' => [
                self::EVENT_BEFORE_INSERT => ['created_at'],
            ],
        ];

        return $behaviors;
    }

    public function rules()
    {
        return [
            [['phone', 'data', 'created_at'], 'required'],
            [['success', 'created_at'], 'integer'],
            [['phone', 'data'], 'string', 'max' => 255],
        ];
    }
}
