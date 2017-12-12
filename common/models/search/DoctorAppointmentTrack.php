<?php

namespace common\models\search;

use common\models\DoctorAppointmentTrack as DoctorAppointmentTrackModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DoctorAppointmentTrack extends DoctorAppointmentTrackModel
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'appointment_id', 'created_at', 'updated_at'], 'integer'],
            [['track_message'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DoctorAppointmentTrackModel::find()->orderBy(['id' => SORT_DESC]);

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
            'id'             => $this->id,
            'user_id'        => $this->user_id,
            'appointment_id' => $this->appointment_id,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'track_message', $this->track_message]);

        return $dataProvider;
    }
}
