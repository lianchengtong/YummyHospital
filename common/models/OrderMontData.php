<?php

namespace common\models;

use common\utils\Cache;

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

    public static function addBatchData($orderID, $dataList)
    {
        foreach ($dataList as $name => $content) {
            $orderMontDataModel           = new OrderMontData();
            $orderMontDataModel->order_id = $orderID;
            $orderMontDataModel->name     = $name;
            $orderMontDataModel->content  = strval($content);
            $saveResult                   = $orderMontDataModel->saveOrError();
            if (true !== $saveResult) {
                //todo: Exception add logger
                return false;
            }
        }

        return true;
    }

    public static function addData($orderID, $name, $content)
    {
        $orderMontDataModel           = new OrderMontData();
        $orderMontDataModel->order_id = $orderID;
        $orderMontDataModel->name     = $name;
        $orderMontDataModel->content  = strval($content);

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

    /**
     * @param $name
     * @param $content
     *
     * @return bool|null|static|\common\models\Order
     */
    public static function getOrder($name, $content)
    {
        $key     = sprintf("%s_%s_%s", self::className(), $name, $content);
        $orderID = Cache::getOrSet($key, function () use ($name, $content) {
            $condition = [
                'name'    => $name,
                'content' => $content,
            ];

            /** @var self $model */
            $model = self::find()->where($condition)->one();
            if (!$model) {
                return false;
            }
            $orderID = $model->order_id;

            return $orderID;
        });

        if (!$orderID) {
            return false;
        }

        return Order::getByID($orderID);
    }

    public static function getOrderIDByName($name, $value)
    {
        $condition = [
            'name'    => $name,
            'content' => $value,
        ];
        /** @var self $model */
        $model = self::find()->where($condition)->one();

        return $model->order_id;
    }
}
