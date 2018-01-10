<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_coin_history".
 *
 * @property int    $id
 * @property int    $user_id
 * @property int    $coin
 * @property string $action
 * @property string $desc
 * @property int    $created_at
 */
class UserCoinHistory extends \common\base\ActiveRecord
{
    const ACTION_ADD  = "+";
    const ACTION_DESC = "-";

    public function behaviors()
    {
        return [
            [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'coin', 'action', 'desc', 'created_at'], 'required'],
            [['user_id', 'coin', 'created_at'], 'integer'],
            [['action'], 'string', 'max' => 1],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'user_id'    => 'User ID',
            'coin'       => 'Coin',
            'action'     => 'Action',
            'desc'       => 'Desc',
            'created_at' => 'Created At',
        ];
    }
}
