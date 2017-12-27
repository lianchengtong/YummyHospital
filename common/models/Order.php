<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $order_id
 * @property string $out_trade_id
 * @property string $channel
 * @property string $name
 * @property integer $price
 * @property integer $status
 * @property integer $complete_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class Order extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'out_trade_id', 'channel', 'name', 'price', 'status', 'complete_at', 'created_at', 'updated_at'], 'required'],
            [['price', 'status', 'complete_at', 'created_at', 'updated_at'], 'integer'],
            [['order_id', 'out_trade_id', 'channel', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'out_trade_id' => 'Out Trade ID',
            'channel' => 'Channel',
            'name' => 'Name',
            'price' => 'Price',
            'status' => 'Status',
            'complete_at' => 'Complete At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
