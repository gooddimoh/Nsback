<?php

namespace backend\forms\order;

use core\entities\order\Order;
use core\entities\payment\Payment;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class OrderSearch extends Model
{
    public $id;
    public $invoice_id;
    public $product_id;
    public $email;
    public $status;
    public $method;

    public function rules()
    {
        return [
            [['id'], 'trim'],
            [['id', 'product_id', 'status', 'method'], 'integer'],
            [['email', 'invoice_id'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Order::findConsiderRole();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => ['pageSizeLimit' => [1, 500]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            Order::tableName() . '.id' => $this->id,
            Order::tableName() . '.invoice_id' => $this->invoice_id,
            Order::tableName() . '.product_id' => $this->product_id,
            Order::tableName() . '.status' => $this->status,
            Payment::tableName() . '.method' => $this->method,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

}
