<?php

namespace common\models\search;

use common\models\Article as ArticleModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Article extends ArticleModel
{
    public function rules()
    {
        return [
            [['id', 'category', 'author_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'slug', 'head_image', 'description', 'keyword'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ArticleModel::find();

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
            'category'   => $this->category,
            'author_id'  => $this->author_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
              ->andFilterWhere(['like', 'slug', $this->slug])
              ->andFilterWhere(['like', 'head_image', $this->head_image])
              ->andFilterWhere(['like', 'description', $this->description])
              ->andFilterWhere(['like', 'keyword', $this->keyword]);

        return $dataProvider;
    }
}
