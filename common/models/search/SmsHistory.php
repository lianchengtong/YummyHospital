<?php

namespace common\models\search;

use common\models\SmsHistory as SmsHistoryModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SmsHistory extends SmsHistoryModel
{
    public function rules()
    {
        return [
            [['id', 'success', 'created_at'], 'integer'],
            [['phone', 'data'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SmsHistoryModel::find()->orderBy(['id' => SORT_DESC]);

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
            'success'    => $this->success,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
              ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
