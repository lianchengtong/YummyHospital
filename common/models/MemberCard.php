<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "member_card".
 *
 * @property int    $id
 * @property int    $name
 * @property int    $price
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
            [['price', 'discount', 'pay_discount', 'time_long', 'order', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description', 'options'], 'string'],
            [['description', 'options'], 'default', 'value' => ''],
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

    public function getOptions($key)
    {
        $options = json_decode($this->options);
        return $options[$key];
    }
}
