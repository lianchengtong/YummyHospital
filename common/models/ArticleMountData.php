<?php

namespace common\models;

use common\models\interfaces\InterfaceArticleMontData;

/**
 * This is the model class for table "article_mount_data".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string  $tag
 * @property string  $data
 */
class ArticleMountData extends \common\base\ActiveRecord implements InterfaceArticleMontData
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'article_id' => 'Article ID',
            'tag'        => 'Tag',
            'data'       => 'Data',
        ];
    }

    public function rules()
    {
        return [
            [['article_id', 'tag'], 'required'],
            [['article_id'], 'integer'],
            [['data'], 'string'],
            [['tag'], 'string', 'max' => 255],
        ];
    }

    public function getData()
    {
        return $this->data;
    }

    public function getFieldName()
    {
        return $this->tag;
    }

    public static function getModel($tagName, $articleID)
    {
        $model = self::find()->where(['tag' => $tagName, 'article_id' => $articleID])->one();
        if (!$model) {
            return new self();
        }
        return $model;
    }

    public function setData($articleID, $tag, $data)
    {
        $this->article_id = $articleID;
        $this->data       = $data;
        $this->tag        = $tag;
    }
}
