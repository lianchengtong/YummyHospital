<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "member_own_card".
 *
 * @property int $id
 * @property int $user_id
 * @property int $original_money
 * @property int $remain_money
 * @property int $discount
 * @property int $expire_at
 * @property int $created_at
 */
class MemberOwnCard extends \common\base\ActiveRecord
{
    public function behaviors()
    {
        return [
            'class'      => TimestampBehavior::className(),
            'attributes' => [
                self::EVENT_BEFORE_INSERT => [$this->createdAtAttribute],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'original_money', 'remain_money', 'discount'], 'required'],
            [['user_id', 'original_money', 'remain_money', 'discount', 'expire_at', 'created_at'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'user_id'        => 'User ID',
            'original_money' => 'Original Money',
            'remain_money'   => 'Remain Money',
            'discount'       => 'Discount',
            'expire_at'      => 'Expire At',
            'created_at'     => 'Created At',
        ];
    }
}
