<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "member_own_card".
 *
 * @property int    $id
 * @property int    $user_id
 * @property double $original_money
 * @property double $remain_money
 * @property int    $discount
 * @property int    $is_enable
 * @property int    $expire_at
 * @property int    $created_at
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
            [['user_id', 'discount', 'is_enable', 'expire_at', 'created_at'], 'integer'],
            ['is_enable', 'default', 'value' => 1],
            [['original_money', 'remain_money'], 'number'],
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

    public static function buyCard($userID, $cardID)
    {
        /** @var \common\models\MemberCard $cardModel */
        $cardModel = MemberCard::findOne($cardID);
        if (!$cardModel) {
            return false;
        }

        $model                 = new self();
        $model->user_id        = $userID;
        $model->original_money = $cardModel->price;
        $model->remain_money   = $cardModel->price;
        $model->discount       = $cardModel->discount;
        $model->expire_at      = strtotime(sprintf("+%d month", $cardModel->time_long));

        return $model->saveOrError();
    }

    public static function isUserHasCard($userID)
    {
        return !is_null(self::getUserEnableCard($userID));
    }

    /**
     * @param $userID
     *
     * @return array|null|\yii\db\ActiveRecord|self
     */
    public static function getUserEnableCard($userID)
    {
        return self::find()->where(['user_id' => $userID, 'is_enable' => 1])->one();
    }

    public static function descMoneyByOrderID($orderID)
    {
        $orderModel = Order::getByOrderID($orderID);
        if (!$orderModel) {
            return false;
        }

        $model = self::getUserEnableCard($orderModel->user_id);
        if (!$model) {
            return false;
        }

        $orderPrice    = $orderModel->getPriceYuan();
        $discountMoney = $model->getDiscountMoney($orderPrice);
        if ($discountMoney < $orderPrice) {
            return false;
        }

        $model->remain_money -= $discountMoney;
        if ($model->remain_money == 0) {
            $model->is_enable = 0;
        }

        return $model->save();
    }

    public function getDiscountMoney($price)
    {
        return sprintf("%0.2f", $this->discount * $price / 100);
    }
}
