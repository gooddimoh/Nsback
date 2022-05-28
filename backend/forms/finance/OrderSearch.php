<?php

namespace backend\forms\finance;

use core\entities\order\Order;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class OrderSearch extends Model
{
    public $id;
    public $product_id;
    public $email;
    public $status;

    public function rules()
    {
        return [
            [['id', 'product_id', 'status'], 'integer'],
            [['email'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = Order::find();

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
            'product_id' => $this->product_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

}
