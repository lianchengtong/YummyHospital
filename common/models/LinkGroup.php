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
    protected $enableTimeBehavior = FALSE;

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
            'name' => 'Name',
            'slug' => 'Slug',
        ];
    }
}
