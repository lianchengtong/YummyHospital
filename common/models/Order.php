<?php

namespace common\models;

/**
 * This is the model class for table "order".
 *
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $order_id
 * @property string  $out_trade_id
 * @property string  $channel
 * @property string  $name
 * @property integer $price
 * @property integer $status
 * @property integer $complete_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class Order extends \common\base\ActiveRecord
{
    const STATUS_PENDING_PAY = 0;
    const STATUS_PAY_SUCCESS = 1;
    const STATUS_PAY_REFUND  = 2;
    const STATUS_PAY_CLOSED  = 3;

    const CHANNEL_ALIPAY    = "alipay";
    const CHANNEL_WECHATPAY = "wechatpay";
    const CHANNEL_OFFLINE   = "offline";

    public static function create($channel, $name, $price)
    {
        $model = new self();
        $model->setAttributes([
            'order_id' => self::generateOrderID(),
            'price'    => $price * 100,
            'name'     => $name,
            'channel'  => $channel,
        ]);
        if (!$model->save()) {
            return false;
        }

        return $model;
    }

    public static function generateOrderID()
    {
        $orderID = sprintf("%s%s%05d", date("Ymdhis"), uniqid(), mt_rand(1, 999));

        return $orderID;
    }

    /**
     * @param $orderID
     *
     * @return array|null|\yii\db\ActiveRecord|self
     */
    public static function getByOrderID($orderID)
    {
        return self::find()->where(['order_id' => $orderID])->one();
    }

    // 把分值转换为yuan
    public function getPriceYuan()
    {
        return sprintf("%0.2f", $this->price / 100);
    }

    public function completeWithTradeNumber($outTradeNumber)
    {
        $this->out_trade_id = $outTradeNumber;
        $this->complete_at  = time();
        $this->status       = self::STATUS_PAY_SUCCESS;

        return $this->save();
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this->save();
    }

    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'user_id'      => '购买用户',
            'order_id'     => '订单号',
            'out_trade_id' => '渠道订单号',
            'channel'      => '渠道',
            'name'         => '名称',
            'price'        => '价格',
            'status'       => '状态',
            'complete_at'  => '完成时间',
            'created_at'   => '创建时间',
            'updated_at'   => '更新时间',
        ];
    }

    public function rules()
    {
        return [
            [['order_id', 'user_id', 'channel', 'name', 'price'], 'required'],
            [['price', 'status', 'user_id', 'complete_at', 'created_at', 'updated_at'], 'integer'],
            [['order_id', 'out_trade_id', 'channel', 'name'], 'string', 'max' => 255],
            [['out_trade_id'], 'default', 'value' => ''],
            [['complete_at'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => self::STATUS_PENDING_PAY],
        ];
    }

    public static function getPayChannel($partial = [])
    {
        $list = [
            self::CHANNEL_ALIPAY    => '支付宝',
            self::CHANNEL_WECHATPAY => '微信支付',
            self::CHANNEL_OFFLINE   => '到院支付',
        ];

        if (!empty($partial)) {
            $partialList = [];
            foreach ($partial as $item) {
                $partialList[$item] = $list[$item];
            }
            $list = $partialList;
        }

        return $list;
    }
}
