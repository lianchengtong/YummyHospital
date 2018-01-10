<?php

namespace common\models\search;

use common\models\PromotionCard as PromotionCardModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PromotionCard extends PromotionCardModel
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'card_worth', 'active_at', 'created_at'], 'integer'],
            [['card_number', 'batch_code'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PromotionCardModel::find()->orderBy(['id' => SORT_DESC]);

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
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'card_worth' => $this->card_worth,
            'active_at'  => $this->active_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'card_number', $this->card_number])
              ->andFilterWhere(['like', 'batch_code', $this->batch_code]);

        return $dataProvider;
    }
}
