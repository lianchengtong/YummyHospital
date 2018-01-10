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
}
