<?php

namespace common\models;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string  $title
 * @property string  $type
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
    /** @var \common\models\interfaces\InterfaceArticleMontData[] */
    public $fieldModels;
    public $field = [];

    public function init()
    {
        parent::init();
        $this->initFieldData();
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'title'       => '标题',
            'type'        => '类型',
            'slug'        => '别名',
            'head_image'  => '头图',
            'category'    => '分类',
            'description' => '概要',
            'keyword'     => '关键字',
            'author_id'   => '作者',
            'created_at'  => '创建时间',
            'updated_at'  => '更新时间',
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


    public function initFieldData()
    {
        $typeFields = ArticleTypeField::getFieldsByTypeID($this->type);
        foreach ($typeFields as $typeField) {
            $fieldMapClass = $this->getFieldMapClass($typeField);
            if (is_null($this)) {
                $this->fieldModels[$typeField] = new $fieldMapClass();
                continue;
            }

            $typeFieldModel                = $fieldMapClass::getModel($typeField, $this->id);
            $this->fieldModels[$typeField] = $typeFieldModel;
        }

        foreach ($this->fieldModels as $fieldModel) {
            $this->field[$fieldModel->getFieldName()] = $fieldModel->getData();
        }
    }

    /**
     * @param $name
     *
     * @return mixed|string
     */
    public function getFieldMapClass($name)
    {
        $mapList = [
            'content' => ArticleContent::className(),
        ];
        if (!isset($mapList[$name])) {
            return ArticleMountData::className();
        }

        return $mapList[$name];
    }

    public function getFieldModelData($fieldName)
    {
        $model = $this->getFieldModel($fieldName);
        if (!is_null($model)) {
            return $model->getData();
        }

        return "";
    }

    /**
     * @param $fieldName
     *
     * @return \common\models\interfaces\InterfaceArticleMontData|\common\base\ActiveRecord
     */
    public function getFieldModel($fieldName)
    {
        return $this->fieldModels[$fieldName];
    }
}
