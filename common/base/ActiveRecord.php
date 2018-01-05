<?php

namespace common\base;


use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class ActiveRecord extends \yii\db\ActiveRecord
{
    protected $enableTimeBehavior = true;

    public function behaviors()
    {
        $behaviors = [];
        if ($this->enableTimeBehavior) {
            $behaviors[] = [
                'class' => TimestampBehavior::className(),
            ];
        }

        return $behaviors;
    }

    public static function command($sql, $params)
    {
        return self::getDb()->createCommand($sql, $params);
    }

    public static function tableName()
    {
        $class = array_pop(explode("\\", get_called_class()));
        $class = preg_replace('/([A-Z])/', '_${1}', $class);

        return '{{%' . trim(strtolower($class), "_") . '}}';
    }

    public function getErrorList()
    {
        $errors = [];
        foreach ($this->getErrors() as $attribute => $error) {
            $errors[] = implode(",", $error);
        }

        return $errors;
    }

    public static function getByID($id)
    {
        return self::findOne($id);
    }


    public static function getMapByColumn($column, $condition = [])
    {
        $list = self::find()->select($column)->where($condition)->all();
        return ArrayHelper::map($list, "id", $column);
    }

    public function saveOrError()
    {
        if (!$this->save()) {
            return $this->getErrors();
        }
        return true;
    }

    public static function count($condition = [])
    {
        return self::find()->where($condition)->count();
    }
}