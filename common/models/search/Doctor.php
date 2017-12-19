<?php

namespace common\models\search;

use common\models\Doctor as DoctorModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Doctor extends DoctorModel
{
    public function rules()
    {
        return [
            [['id', 'level', 'name', 'work_time'], 'integer'],
            [['head_image', 'summary', 'introduce', 'rank'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DoctorModel::find()->with("doctorServiceTime");

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
            'level'     => $this->level,
            'name'      => $this->name,
            'work_time' => $this->work_time,
        ]);

        $query->andFilterWhere(['like', 'head_image', $this->head_image])
              ->andFilterWhere(['like', 'summary', $this->summary])
              ->andFilterWhere(['like', 'introduce', $this->introduce])
              ->andFilterWhere(['like', 'rank', $this->rank]);

        return $dataProvider;
    }
}
