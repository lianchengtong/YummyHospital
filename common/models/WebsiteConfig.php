<?php

namespace common\models;


use common\utils\Cache;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "website_config".
 *
 * @property integer $id
 * @property string $key
 * @property string $name
 * @property string $value
 * @property string $type
 * @property string $const_data
 * @property integer $group_id
 * @property integer $order
 * @property integer $hint
 * @property integer $created_at
 */
class WebsiteConfig extends \common\base\ActiveRecord
{
    const TYPE_SPLIT = "split";
    const TYPE_STRING = "string";
    const TYPE_TEXT = "text";
    const TYPE_SINGLE_SELECTION = "single";
    const TYPE_MULTIPLE_SELECTION = "multiple";

    public static function getTypeName($typeID)
    {
        $list = self::getTypeList();

        return $list[$typeID];
    }

    public static function getTypeList()
    {
        return [
            self::TYPE_SPLIT => '分割行',
            self::TYPE_STRING => '字符串',
            self::TYPE_TEXT => '文本',
            self::TYPE_SINGLE_SELECTION => '单选',
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

    public static function getAll()
    {
        return Cache::getOrSet("website_config", function () {
            /** @var self[] $models */
            $models = self::find()->all();

            $keyValue = [];
            foreach ($models as $model) {
                if ($model->type == self::TYPE_SPLIT) {
                    continue;
                }
                $keyValue[$model->key] = $model->value;
            }

            return $keyValue;
        });
    }

    public static function clearCache()
    {
        Cache::delete("website_config");
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
        $list = self::getAll();

        return $list[$key];
    }

    public static function getMultiValue($keys)
    {
        $list = self::getAll();
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $list[$key];
        }

        return $data;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => '键',
            'name' => '名称',
            'value' => '值',
            'type' => '类型',
            'hint' => '提示',
            'const_data' => '预置数据',
            'group_id' => '分组',
            'order' => '排序',
            'created_at' => '创建日期',
        ];
    }

    public function behaviors()
    {
        $behaviors = [];
        if ($this->enableTimeBehavior) {
            $behaviors[] = [
                'class' => TimestampBehavior::className(),
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
            [['value', 'const_data', 'hint'], 'string'],
            [['group_id', 'order', 'created_at'], 'integer'],
            [['key', 'type'], 'string', 'max' => 255],
            [['order'], 'default', 'value' => 0],
            [['value', 'hint'], 'default', 'value' => ""],
            [['type'], 'default', 'value' => self::TYPE_STRING],
        ];
    }

    public function getFormKey()
    {
        return sprintf("%s[%s]", $this->formName(), $this->key);
    }
}
