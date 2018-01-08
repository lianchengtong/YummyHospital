<?php

namespace common\models;

/**
 * This is the model class for table "order_mont_data".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string  $name
 * @property string  $content
 */
class OrderMontData extends \common\base\ActiveRecord
{
    protected $enableTimeBehavior = false;

    public function rules()
    {
        return [
            [['order_id', 'name', 'content'], 'required'],
            [['name', 'content'], 'string', 'max' => 255],
            [['order_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'order_id' => '订单 ID',
            'name'     => '名称',
            'content'  => '内容',
        ];
    }

    public static function addData($orderID, $name, $data)
    {
        $orderMontDataModel           = new OrderMontData();
        $orderMontDataModel->order_id = $orderID;
        $orderMontDataModel->name     = $name;
        $orderMontDataModel->content  = $data;

        return $orderMontDataModel->saveOrError();
    }

    public static function getCallback($className, $callback, $params)
    {
        return json_encode([
            'callback' => [$className, $callback],
            'params'   => $params,
        ]);
    }

    public static function getCallbackList($orderID)
    {
        /** @var self[] $models */
        $models = self::find()->where(['order_id' => $orderID, 'name' => 'callback'])->all();

        $callbacks = [];
        foreach ($models as $model) {
            $callback = json_decode($model->content, true);
            if (!$callback) {
                continue;
            }
            $callbacks[] = $callback;
        }

        return $callbacks;
    }
}
