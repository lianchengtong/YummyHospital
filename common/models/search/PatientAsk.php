<?php

namespace common\models\search;

use common\models\PatientAsk as PatientAskModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PatientAsk extends PatientAskModel
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'doctor_id', 'patient_id', 'reply_at', 'created_at', 'updated_at'], 'integer'],
            [['description', 'images', 'reply'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PatientAskModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!isset($params['sort'])) {
            $params['sort'] = "-id";
        }

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
            'doctor_id'  => $this->doctor_id,
            'patient_id' => $this->patient_id,
            'reply_at'   => $this->reply_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
              ->andFilterWhere(['like', 'images', $this->images])
              ->andFilterWhere(['like', 'reply', $this->reply]);

        return $dataProvider;
    }
}
