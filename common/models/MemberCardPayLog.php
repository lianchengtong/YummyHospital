<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "member_card_pay_log".
 *
 * @property int                  $id
 * @property int                  $card_id
 * @property int                  $order_id
 * @property double               $pay_price
 * @property double               $card_price
 * @property int                  $created_at
 *
 * @property \common\models\Order $order
 */
class MemberCardPayLog extends \common\base\ActiveRecord
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

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    public static function add($cardID, $orderID, $price, $cardPrice)
    {
        $model = new self();
        $model->setAttributes([
            'card_id'    => $cardID,
            'order_id'   => $orderID,
            'pay_price'  => $price,
            'card_price' => $cardPrice,
        ]);

        return $model->saveOrError();
    }
}
