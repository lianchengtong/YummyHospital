<?php

namespace common\models;

/**
 * This is the model class for table "card_password".
 *
 * @property int    $id
 * @property int    $user_id
 * @property string $password
 * @property string $salt
 */
class CardPassword extends \common\base\ActiveRecord
{
    public function rules()
    {
        return [
            [['user_id', 'password', 'salt'], 'required'],
            [['user_id'], 'integer'],
            [['password', 'salt'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'user_id'  => 'User ID',
            'password' => 'Password',
            'salt'     => 'Salt',
        ];
    }

    public static function getByUserID($userID)
    {
        return self::find()->where(['user_id' => $userID])->one();
    }

    public static function setPassword($userID, $password)
    {
        $model = self::getByUserID($userID);
        if (!$model) {
            $model       = new self();
            $model->salt = \Yii::$app->getSecurity()->generateRandomKey(5);
        }
        $model->password = sprintf("%s-%s", $model->salt, $password);

        return $model->saveOrError();
    }
}
