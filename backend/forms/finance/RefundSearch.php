<?php

namespace backend\forms\finance;

use core\entities\order\Refund;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class RefundSearch extends Model
{
    public $id;
    public $order_id;
    public $user_id;
    public $email;
    public $type;
    public $refund_to_balance;
    public $comment;

    public function rules()
    {
        return [
            [['id', 'order_id', 'type', 'user_id'], 'integer'],
            [['refund_to_balance'], 'boolean'],
            [['comment', 'email'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Refund::find()->joinWith('order');

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
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'email' => $this->email,
            'type' => $this->type,
            'refund_to_balance' => $this->refund_to_balance,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

}
