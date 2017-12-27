<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_mont_data".
 *
 * @property integer $id
 * @property string $order_id
 * @property string $name
 * @property string $content
 */
class OrderMontData extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_mont_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'name', 'content'], 'required'],
            [['order_id', 'name', 'content'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'content' => 'Content',
        ];
    }
}
