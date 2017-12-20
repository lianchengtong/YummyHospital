<?php

namespace common\models;

use common\models\interfaces\InterfaceArticleMontData;

/**
 * This is the model class for table "article_content".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string  $content
 */
class ArticleContent extends \common\base\ActiveRecord implements InterfaceArticleMontData
{
    protected $enableTimeBehavior = false;

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'article_id' => 'Article ID',
            'content'    => 'Content',
        ];
    }

    public function rules()
    {
        return [
            [['article_id'], 'required'],
            [['article_id'], 'integer'],
            [['content'], 'string'],
        ];
    }

    public function getFieldName()
    {
        return "content";
    }

    public function getData()
    {
        return $this->content;
    }

    public static function getModel($tagName, $articleID)
    {
        $model = self::find()->where(['article_id' => $articleID])->one();
        if (!$model) {
            return new self();
        }
        return $model;
    }

    public function setData($articleID, $tag, $data)
    {
        $this->article_id = $articleID;
        $this->content    = $data;
    }
}
