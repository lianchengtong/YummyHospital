<?php

namespace common\models;

/**
 * This is the model class for table "article_content".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string  $content
 */
class ArticleContent extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = FALSE;

    public function rules()
    {
        return [
            [['article_id'], 'required'],
            [['article_id'], 'integer'],
            [['content'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'article_id' => 'Article ID',
            'content'    => 'Content',
        ];
    }
}
