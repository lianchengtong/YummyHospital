<?php

namespace common\models;

/**
 * This is the model class for table "user_coin".
 *
 * @property int $id
 * @property int $user_id
 * @property int $coin
 */
class UserCoin extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public function rules()
    {
        return [
            [['user_id', 'coin'], 'required'],
            [['user_id', 'coin'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'user_id' => 'User ID',
            'coin'    => 'Coin',
        ];
    }

    /**
     * @param $userID
     *
     * @return array|null|\yii\db\ActiveRecord|self
     */
    public static function getByUserID($userID)
    {
        return self::find()->where(['user_id' => $userID])->one();
    }

    public static function cost($userID, $count, $desc = "")
    {
        $model = self::getByUserID($userID);
        if (!$model) {
            return true;
        }

        $result = UserCoinHistory::add($userID, UserCoinHistory::ACTION_DESC, $count, $desc);
        if (true !== $result) {
            return $result;
        }

        $model->coin -= $count;
        if ($model->coin < 0) {
            return false;
        }

        return $model->saveOrError();
    }
}
