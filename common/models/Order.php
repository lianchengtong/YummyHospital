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

    const CHANNEL_UNKNOWN   = "unknown";
    const CHANNEL_FREE      = "free";
    const CHANNEL_CARD      = "card";
    const CHANNEL_ALIPAY    = "alipay";
    const CHANNEL_WECHATPAY = "wechat-pay";
    const CHANNEL_OFFLINE   = "offline";

    public static function create($userID, $name, $price)
    {
        $model = new self();
        $model->setAttributes([
            'order_id' => self::generateOrderID(),
            'user_id'  => $userID,
            'price'    => $price * 100,
            'name'     => $name,
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
        $floatPrice = sprintf("%0.2f", $this->price / 100);
        if (substr($floatPrice, -3) == ".00") {
            return intval($floatPrice);
        }

        return $floatPrice;
    }

    public function completeWithTradeNumber($outTradeNumber, $channel)
    {
        $this->out_trade_id = $outTradeNumber;
        $this->complete_at  = time();
        $this->channel      = $channel;
        $this->status       = self::STATUS_PAY_SUCCESS;

        return $this->saveOrError();
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
            [['order_id', 'user_id', 'name', 'price'], 'required'],
            [['price', 'status', 'user_id', 'complete_at', 'created_at', 'updated_at'], 'integer'],
            [['order_id', 'out_trade_id', 'channel', 'name'], 'string', 'max' => 255],
            [['out_trade_id'], 'default', 'value' => ''],
            [['complete_at'], 'default', 'value' => 0],
            [['channel'], 'default', 'value' => self::CHANNEL_UNKNOWN],
            [['status'], 'default', 'value' => self::STATUS_PENDING_PAY],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getWechatAuth()
    {
        return $this->hasOne(AuthWechat::className(), ['user_id' => 'user_id']);
    }

    public static function getPayChannel($partial = [])
    {
        $list = [
            self::CHANNEL_CARD      => '会员卡',
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

    public function runCallbacks()
    {
        $orderMontCallbacks = OrderMontData::getCallbackList($this->primaryKey);
        if ($this->status != self::STATUS_PENDING_PAY) {
            throw new \Exception("invalid order status");
        }

        foreach ($orderMontCallbacks as $callback) {
            array_unshift($callback['params'], $this);
            call_user_func_array($callback['callback'], $callback['params']);
        }
    }

    public function getMontData()
    {
        return $this->hasMany(OrderMontData::className(), [
            'order_id' => 'id',
        ]);
    }

    public function getIsPaySuccess()
    {
        return $this->status == self::STATUS_PAY_SUCCESS;
    }

    public static function getListByUser($userID)
    {
        return self::find()->where(['user_id' => $userID])->orderBy(['id' => SORT_DESC])->all();
    }

    public function montData($key)
    {
        foreach ($this->montData as $item) {
            if ($item->name == $key) {
                return $item;
            }
        }

        return null;
    }

    public static function channelName($channelID)
    {
        $channelList = self::getPayChannel();

        return $channelList[$channelID];
    }
}
