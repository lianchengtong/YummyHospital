<?php

namespace common\models;

use yii\base\UnknownMethodException;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sms_history".
 *
 * @method static bool addAliYunMessage(string $type, string $phone, bool $isSuccess = false, string $data = "")
 *
 * @property integer $id
 * @property string  $phone
 * @property string  $type
 * @property string  $channel
 * @property integer $success
 * @property string  $data
 * @property integer $created_at
 */
class SmsHistory extends \common\base\ActiveRecord
{
    const TYPE_LOGIN           = "login";
    const TYPE_REGISTER        = "register";
    const TYPE_FIND_PASSWORD   = "find-password";
    const TYPE_MODIFY_PASSWORD = "modify-password";
    const TYPE_OPERATION       = "operation";


    protected $enableTimeBehavior = true;

    public static function addMessage($channel, $type, $phone, $isSuccess = false, $data = "")
    {
        $model = new self();
        $model->setAttributes([
            'type'    => $type,
            'phone'   => $phone,
            'success' => $isSuccess,
            'data'    => json_encode($data),
        ]);

        return $model->save();
    }

    public static function __callStatic($name, $arguments)
    {
        if (substr($name, 0, 3) != "add" && substr($name, -7) != "Message") {
            throw new UnknownMethodException($name);
        }

        array_unshift($arguments, substr($name, 3, -7));
        return call_user_func_array([self::className(), $name], $arguments);
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
