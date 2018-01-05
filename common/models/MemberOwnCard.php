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
            [['user_id', 'original_money', 'remain_money', 'discount'], 'required'],
            [['user_id', 'original_money', 'remain_money', 'discount', 'expire_at', 'created_at'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'user.nickname'  => '购买用户',
            'user_id'        => 'User ID',
            'original_money' => '原价',
            'remain_money'   => '余额',
            'discount'       => '消费折扣',
            'expire_at'      => '过期时间',
            'created_at'     => '购买日期',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
