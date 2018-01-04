<?php

namespace common\models;

/**
 * This is the model class for table "order_mont_data".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string  $name
 * @property string  $content
 */
class OrderMontData extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public function rules()
    {
        return [
            [['order_id', 'name', 'content'], 'required'],
            [['name', 'content'], 'string', 'max' => 255],
            [['order_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'order_id' => '订单 ID',
            'name'     => '名称',
            'content'  => '内容',
        ];
    }
}
