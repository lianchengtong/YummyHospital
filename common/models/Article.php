<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $head_image
 * @property integer $category
 * @property string $description
 * @property string $keyword
 * @property integer $author_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Article extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'category', 'author_id'], 'required'],
            [['category', 'author_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'slug', 'head_image', 'description', 'keyword'], 'string', 'max' => 255],
            [['slug'], 'unique'],
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
            'slug' => 'Slug',
            'head_image' => 'Head Image',
            'category' => 'Category',
            'description' => 'Description',
            'keyword' => 'Keyword',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
