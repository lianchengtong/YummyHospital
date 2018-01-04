<?php

namespace common\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $order
 * @property \common\models\ArticleTypeField[] $inputFields
 */
class ArticleType extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public static function setOrder($id, $orderNum)
    {
        return self::updateAll(['order' => $orderNum], ['id' => $id]);
    }

    public static function getBySlug($slug)
    {
        return self::find()->where(['slug' => $slug])->one();
    }

    public static function getByID($id)
    {
        return self::findOne($id);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'slug' => '别名',
            'description' => '描述',
            'order' => '排序',
        ];
    }

    public function rules()
    {
        return [
            [['description'], 'required'],
            [['name', 'slug', 'description'], 'string', 'max' => 255],
            [['description'], 'unique'],
            [['order'], 'integer'],
            [['order'], 'default', 'value' => 0],
        ];
    }

    public function getInputFields()
    {
        return $this->hasMany(ArticleTypeField::className(), ['type_id' => 'id']);
    }

    public static function getList()
    {
        $models = self::find()->all();

        return ArrayHelper::map($models, "id", "name");
    }
}
