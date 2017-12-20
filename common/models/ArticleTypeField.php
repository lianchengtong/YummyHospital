<?php

namespace common\models;

/**
 * This is the model class for table "article_type_field".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string  $name
 * @property string  $description
 * @property string  $class
 * @property string  $configure
 * @property integer $order
 */
class ArticleTypeField extends \common\base\ActiveRecord
{
    public function afterFind()
    {
        parent::afterFind();

        $this->configure = json_decode($this->configure, true);
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'type_id'     => 'Type ID',
            'name'        => 'Name',
            'description' => 'Description',
            'class'       => 'Class',
            'configure'   => 'Configure',
            'order'       => 'Order',
        ];
    }

    public function rules()
    {
        return [
            [['type_id', 'class', 'configure'], 'required'],
            [['type_id', 'order'], 'integer'],
            [['name', 'description', 'class', 'configure'], 'string', 'max' => 255],
            [['configure'], 'unique'],
        ];
    }
}
