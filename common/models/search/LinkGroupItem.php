<?php

namespace common\models\search;

use common\models\LinkGroupItem as LinkGroupItemModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class LinkGroupItem extends LinkGroupItemModel
{
    public function rules()
    {
        return [
            [['id', 'link_group_id', 'order', 'type', 'pid'], 'integer'],
            [['name', 'options', 'slug', 'data'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = LinkGroupItemModel::find();

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
            'id'            => $this->id,
            'link_group_id' => $this->link_group_id,
            'type'          => $this->type,
            'pid'           => $this->pid,
            'order'         => $this->order,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'slug', $this->slug])
              ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
