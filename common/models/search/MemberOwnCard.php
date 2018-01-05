<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MemberOwnCard as MemberOwnCardModel;

class MemberOwnCard extends MemberOwnCardModel
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'original_money', 'remain_money', 'discount', 'expire_at', 'created_at'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MemberOwnCardModel::find();

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
            'user_id' => $this->user_id,
            'original_money' => $this->original_money,
            'remain_money' => $this->remain_money,
            'discount' => $this->discount,
            'expire_at' => $this->expire_at,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
