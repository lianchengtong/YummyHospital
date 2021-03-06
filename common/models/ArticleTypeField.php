<?php

namespace common\models;

use application\builder\Input;
use application\modules\manage\forms\ArticleForm;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article_type_field".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $name
 * @property string $field
 * @property string $description
 * @property string $class
 * @property string $configure
 * @property integer $order
 * @property boolean $side_show
 */
class ArticleTypeField extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public static function setOrder($id, $orderNum)
    {
        return self::updateAll(['order' => $orderNum], ['id' => $id]);
    }

    public static function getFieldsByTypeID($typeID)
    {
        $models = self::find()->where(['type_id' => $typeID])->select("field")->all();

        return ArrayHelper::getColumn($models, "field");
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => '类型ID',
            'name' => '名称',
            'field' => '字段',
            'description' => '描述',
            'class' => '类',
            'configure' => '配置',
            'order' => '排序',
            'side_show' => '是否边栏展示',
        ];
    }

    public function rules()
    {
        return [
            [['name', 'side_show', 'field', 'type_id', 'class', 'configure'], 'required'],
            [['type_id', 'order'], 'integer'],
            [['name', 'description', 'class', 'configure'], 'string', 'max' => 255],
            ['order', 'default', 'value' => 0],
        ];
    }

    public function showInput(ArticleForm $model, $isSideShow = false)
    {
        if ($isSideShow && !$this->side_show) {
            return "";
        }

        $configure = $this->getConfigureData();
        $fieldName = sprintf("%s[field][%s]", $model->formName(), $this->field);

        ArrayHelper::setValue($configure, "name", $fieldName);
        ArrayHelper::setValue($configure, "value", $model->getArticleModel()->getFieldModelData($this->field));

        ArrayHelper::setValue($configure['customOptions'], "class", $this->class);
        ArrayHelper::setValue($configure['customOptions'], "class", $this->class);
        ArrayHelper::setValue($configure['customOptions'], "label", $this->name);
        ArrayHelper::setValue($configure['customOptions'], "hint", $this->description);


        return Input::widget($configure);
    }

    public function getConfigureData()
    {
        return json_decode($this->configure, true);
    }
}
