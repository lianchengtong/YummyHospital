<?php

namespace common\models\search;

use common\models\DoctorServiceTime as DoctorServiceTimeModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DoctorServiceTime extends DoctorServiceTimeModel
{
    public function rules()
    {
        return [
            [['id', 'model', 'doctor_id'], 'integer'],
            [['month', 'day', 'am', 'pm', 'week'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DoctorServiceTimeModel::find();

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
            'id'        => $this->id,
            'doctor_id' => $this->doctor_id,
        ]);

        $query->andFilterWhere(['like', 'month', $this->month])
              ->andFilterWhere(['like', 'day', $this->day])
              ->andFilterWhere(['like', 'am', $this->am])
              ->andFilterWhere(['like', 'pm', $this->pm])
              ->andFilterWhere(['like', 'week', $this->week]);

        return $dataProvider;
    }
}
