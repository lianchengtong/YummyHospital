<?php

namespace common\models\search;

use common\models\ArticleType as ArticleTypeModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ArticleType extends ArticleTypeModel
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'slug', 'description'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ArticleTypeModel::find()->orderBy(['order' => SORT_ASC]);

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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'slug', $this->slug])
              ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
