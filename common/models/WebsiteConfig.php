<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "website_config".
 *
 * @property integer $id
 * @property string  $key
 * @property string  $name
 * @property string  $value
 * @property string  $type
 * @property string  $const_data
 * @property integer $group_id
 * @property integer $order
 * @property integer $created_at
 */
class WebsiteConfig extends \common\base\ActiveRecord
{
    const TYPE_STRING             = "string";
    const TYPE_TEXT               = "text";
    const TYPE_SINGLE_SELECTION   = "single";
    const TYPE_MULTIPLE_SELECTION = "multiple";

    public static function getTypeName($typeID)
    {
        $list = self::getTypeList();

        return $list[$typeID];
    }

    public static function getTypeList()
    {
        return [
            self::TYPE_STRING             => '字符串',
            self::TYPE_TEXT               => '文本',
            self::TYPE_SINGLE_SELECTION   => '单选',
            self::TYPE_MULTIPLE_SELECTION => '多选',
        ];
    }

    public static function set($key, $value)
    {
        $model = self::getByKey($key);
        if (!$model) {
            return false;
        }

        $model->value = $value;

        return $model->save();
    }

    /**
     * @param $key
     *
     * @return array|null|\yii\db\ActiveRecord|self
     */
    public static function getByKey($key)
    {
        $model = self::find()->where(['key' => $key])->one();

        return $model;
    }

    public static function getValueByKey($key)
    {
        $model = self::getByKey($key);
        if (!$model) {
            return "";
        }

        return $model->value;
    }

    public static function getMultiValue($keys)
    {
        $models = self::find()->select("key,value")->where(['key' => $keys])->all();
        return ArrayHelper::map($models, "key", "value");
    }

    public function behaviors()
    {
        $behaviors = [];
        if ($this->enableTimeBehavior) {
            $behaviors[] = [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
            ];
        }

        return $behaviors;
    }

    public function rules()
    {
        return [
            [['key'], 'unique'],
            [['key', 'name'], 'required'],
            [['value', 'const_data'], 'string'],
            [['group_id', 'order', 'created_at'], 'integer'],
            [['key', 'type'], 'string', 'max' => 255],
            [['order'], 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'key'        => 'Key',
            'name'       => 'Name',
            'value'      => 'Value',
            'type'       => 'Type',
            'const_data' => 'Const Data',
            'group_id'   => 'Group ID',
            'order'      => 'Order',
            'created_at' => 'Created At',
        ];
    }

    public function getFormKey()
    {
        return sprintf("%s[%s]", $this->formName(), $this->key);
    }
}
