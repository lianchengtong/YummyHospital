<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "website_config".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property string $type
 * @property string $const_data
 * @property integer $group_id
 * @property integer $order
 * @property integer $created_at
 */
class WebsiteConfig extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'website_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['value', 'const_data'], 'string'],
            [['group_id', 'order', 'created_at'], 'integer'],
            [['key', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
            'type' => 'Type',
            'const_data' => 'Const Data',
            'group_id' => 'Group ID',
            'order' => 'Order',
            'created_at' => 'Created At',
        ];
    }
}
