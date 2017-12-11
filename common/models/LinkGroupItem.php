<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "link_group_item".
 *
 * @property integer $id
 * @property integer $link_group_id
 * @property string $name
 * @property string $slug
 * @property integer $type
 * @property integer $pid
 * @property string $data
 */
class LinkGroupItem extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'link_group_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_group_id'], 'required'],
            [['link_group_id', 'type', 'pid'], 'integer'],
            [['name', 'slug', 'data'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link_group_id' => 'Link Group ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'type' => 'Type',
            'pid' => 'Pid',
            'data' => 'Data',
        ];
    }
}
