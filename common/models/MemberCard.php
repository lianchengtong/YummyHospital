<?php

namespace common\models;

/**
 * This is the model class for table "member_card".
 *
 * @property int    $id
 * @property int    $name
 * @property double $price
 * @property int    $discount
 * @property int    $pay_discount
 * @property string $description
 * @property int    $time_long
 * @property int    $order
 * @property string $options
 * @property int    $created_at
 * @property int    $updated_at
 */
class MemberCard extends \common\base\ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'price', 'discount', 'pay_discount'], 'required'],
            [['discount', 'pay_discount', 'time_long', 'order', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description', 'options'], 'string'],
            [['description', 'options'], 'default', 'value' => ''],
            [['price'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'name'         => '名称',
            'price'        => '原价',
            'discount'     => '购买折扣',
            'pay_discount' => '支付折扣',
            'description'  => '描述信息',
            'time_long'    => '有效时长(月)',
            'order'        => '排序',
            'options'      => '定制参数',
            'created_at'   => '创建日期',
            'updated_at'   => '更新日期',
        ];
    }

    public function beforeSave($insert)
    {
        $this->price *= 100;

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->price /= 100;

        return parent::afterFind();
    }

    public function getOptionData($key)
    {
        $options = json_decode($this->options);

        return $options[$key];
    }

    // 创建用户会员卡
    public function createForUser($userID)
    {
        $model = new MemberOwnCard();
        $model->setAttributes([
            'user_id'        => $userID,
            'original_money' => $this->price,
            'remain_money'   => $this->price,
            'discount'       => $this->pay_discount,
            'expire_at'      => strtotime(sprintf("+%d month", $this->time_long)),
            'created_at'     => time(),
        ]);

        return $model->saveOrError();
    }
}
