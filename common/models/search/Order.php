<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order as OrderModel;

class Order extends OrderModel
{
    public function rules()
    {
        return [
            [['id', 'price', 'status', 'complete_at', 'created_at', 'updated_at'], 'integer'],
            [['order_id', 'out_trade_id', 'channel', 'name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = OrderModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'status' => $this->status,
            'complete_at' => $this->complete_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'order_id', $this->order_id])
            ->andFilterWhere(['like', 'out_trade_id', $this->out_trade_id])
            ->andFilterWhere(['like', 'channel', $this->channel])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
