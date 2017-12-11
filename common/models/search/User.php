<?php

namespace common\models\search;

use common\models\ManageUser;
use common\models\User as UserModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class User extends UserModel
{
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['phone', 'email', 'nickname', 'auth_key', 'password_hash', 'password_reset_token'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params, $isAdminUser = FALSE)
    {
        $query = UserModel::find();

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
            'status'     => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
              ->andFilterWhere(['like', 'email', $this->email])
              ->andFilterWhere(['like', 'nickname', $this->nickname])
              ->andFilterWhere(['like', 'auth_key', $this->auth_key])
              ->andFilterWhere(['like', 'password_hash', $this->password_hash])
              ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token]);

        if ($isAdminUser) {
            $query->andFilterWhere(['in', 'id', ManageUser::getIDList()]);
        } else {
            $query->andFilterWhere(['not in', 'id', ManageUser::getIDList()]);
        }

        return $dataProvider;
    }
}
