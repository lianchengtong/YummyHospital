<?php

namespace common\models\search;

use common\models\CodeBlock as CodeBlockModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CodeBlock extends CodeBlockModel
{
    public function rules()
    {
        return [
            [['id', 'order'], 'integer'],
            [['name', 'slug', 'code'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CodeBlockModel::find()->orderBy(['order' => SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
