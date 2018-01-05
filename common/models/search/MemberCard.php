<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MemberCard as MemberCardModel;

class MemberCard extends MemberCardModel
{
    public function rules()
    {
        return [
            [['id', 'name', 'price', 'discount', 'pay_discount', 'time_long', 'order', 'created_at', 'updated_at'], 'integer'],
            [['description', 'options'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MemberCardModel::find()->orderBy(['order' => SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => false,
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
            'name'         => $this->name,
            'price'        => $this->price,
            'discount'     => $this->discount,
            'pay_discount' => $this->pay_discount,
            'time_long'    => $this->time_long,
            'order'        => $this->order,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
              ->andFilterWhere(['like', 'options', $this->options]);

        return $dataProvider;
    }


}
