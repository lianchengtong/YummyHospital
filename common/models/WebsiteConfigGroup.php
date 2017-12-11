<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "website_config_group".
 *
 * @property integer $id
 * @property string $name
 * @property integer $order
 * @property integer $created_at
 */
class WebsiteConfigGroup extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'website_config_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['order', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'order' => 'Order',
            'created_at' => 'Created At',
        ];
    }
}
