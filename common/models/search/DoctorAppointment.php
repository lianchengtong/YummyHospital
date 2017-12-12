<?php

namespace common\models\search;

use common\models\DoctorAppointment as DoctorAppointmentModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DoctorAppointment extends DoctorAppointmentModel
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'doctor_id', 'time_begin', 'time_end', 'order_number', 'status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params, $isRecent = FALSE)
    {
        $query = DoctorAppointmentModel::find();
        if ($isRecent) {
            $query->orderBy(['time_begin' => SORT_ASC]);
            $query->andFilterWhere(['>', 'time_begin', strtotime(date("Ymd"))]);
        } else {
            $query->orderBy(['id' => SORT_DESC]);
        }

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
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'doctor_id'    => $this->doctor_id,
            'time_begin'   => $this->time_begin,
            'time_end'     => $this->time_end,
            'order_number' => $this->order_number,
            'status'       => $this->status,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
