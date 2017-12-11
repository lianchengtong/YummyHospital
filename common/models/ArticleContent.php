<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article_content".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $content
 */
class ArticleContent extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id'], 'required'],
            [['article_id'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'content' => 'Content',
        ];
    }
}
