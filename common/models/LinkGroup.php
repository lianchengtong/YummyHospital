<?php

namespace common\models;

/**
 * This is the model class for table "link_group".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $slug
 */
class LinkGroup extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public function rules()
    {
        return [
            [['slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'   => 'ID',
            'name' => '名称',
            'slug' => '别名',
        ];
    }

    public static function getBySlug($slug)
    {
        return self::find()->where(['slug' => $slug])->one();
    }

    /**
     * @param $slug
     * @return array
     */
    public static function getLinkItems($slug)
    {
        $model = self::getBySlug($slug);
        if (!$model) {
            return [];
        }

        return LinkGroupItem::getIndentList($model->id);
    }
}
