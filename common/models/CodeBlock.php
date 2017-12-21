<?php

namespace common\models;

/**
 * This is the model class for table "code_block".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $slug
 * @property string  $code
 * @property integer $order
 */
class CodeBlock extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public static function setOrder($id, $orderNum)
    {
        return self::updateAll(['order' => $orderNum], ['id' => $id]);
    }

    public function attributeHints()
    {
        return [
            'slug' => '必填，全局唯一, 只能为小写字母，可包含[_、-、.]三种符号',
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    => 'ID',
            'name'  => 'Name',
            'slug'  => 'Slug',
            'code'  => 'Code',
            'order' => 'Order',
        ];
    }

    public function rules()
    {
        return [
            [['name', 'slug', 'code'], 'required'],
            [['code'], 'string'],
            [['order'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['slug'], 'match', 'pattern' => '/^[a-z|0-9|\-|\_|\.]+$/'],
        ];
    }
}
