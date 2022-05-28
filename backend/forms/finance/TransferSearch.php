<?php

namespace backend\forms\finance;

use core\entities\transfer\Transfer;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TransferSearch extends Model
{
    public $id;
    public $user_id;
    public $description;
    public $type;

    public function rules()
    {
        return [
            [['id', 'user_id', 'type'], 'integer'],
            [['description'], 'string']
        ];
    }

    public function search($params)
    {
        $query = Transfer::find();

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
            'user_id' => $this->user_id,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
