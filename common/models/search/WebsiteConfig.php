<?php

namespace common\models\search;

use common\models\WebsiteConfig as WebsiteConfigModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class WebsiteConfig extends WebsiteConfigModel
{
    public function rules()
    {
        return [
            [['id', 'group_id', 'order', 'created_at'], 'integer'],
            [['key', 'name', 'value', 'type', 'const_data'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = WebsiteConfigModel::find();

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
            'group_id'   => $this->group_id,
            'order'      => $this->order,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key])
              ->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'value', $this->value])
              ->andFilterWhere(['like', 'type', $this->type])
              ->andFilterWhere(['like', 'const_data', $this->const_data]);

        return $dataProvider;
    }
}
