<?php

namespace common\models;

/**
 * This is the model class for table "member_card_pay_log".
 *
 * @property int    $id
 * @property int    $card_id
 * @property int    $order_id
 * @property double $pay_price
 * @property double $card_price
 * @property int    $created_at
 */
class MemberCardPayLog extends \common\base\ActiveRecord
{
    public function rules()
    {
        return [
            [['card_id', 'order_id', 'pay_price', 'card_price'], 'required'],
            [['card_id', 'order_id', 'created_at'], 'integer'],
            [['pay_price', 'card_price'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'card_id'    => 'Card ID',
            'order_id'   => 'Order ID',
            'pay_price'  => 'Pay Price',
            'card_price' => 'Card Price',
            'created_at' => 'Created At',
        ];
    }
}
