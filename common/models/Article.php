<?php

namespace common\models;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string  $title
 * @property string  $slug
 * @property string  $head_image
 * @property integer $category
 * @property string  $description
 * @property string  $keyword
 * @property integer $author_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Article extends \common\base\ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'title'       => 'Name',
            'slug'        => 'Slug',
            'head_image'  => 'Head Image',
            'category'    => 'Category',
            'description' => 'Description',
            'keyword'     => 'Keyword',
            'author_id'   => 'Author ID',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }

    public function rules()
    {
        return [
            [['slug', 'type', 'category', 'author_id'], 'required'],
            [['category', 'type', 'author_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'slug', 'head_image', 'description', 'keyword'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    public function getContent()
    {
        return $this->hasOne(ArticleContent::className(), ['article_id' => 'id']);
    }

    public function getType()
    {
        return $this->hasOne(ArticleType::className(), ['id' => 'type']);
    }
}
