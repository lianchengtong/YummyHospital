<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article_mount_data".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $tag
 * @property string $data
 */
class ArticleMountData extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_mount_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'tag'], 'required'],
            [['article_id'], 'integer'],
            [['data'], 'string'],
            [['tag'], 'string', 'max' => 255],
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
            'tag' => 'Tag',
            'data' => 'Data',
        ];
    }
}
