<?php

namespace backend\forms\user;

use core\entities\user\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class UserSearch extends Model
{
    public $id;
    public $username;
    public $email;
    public $ip;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'email', 'ip'], 'safe']
        ];
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

}
