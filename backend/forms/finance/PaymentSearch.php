<?php

namespace backend\forms\finance;

use core\entities\payment\Payment;
use core\entities\payment\PaymentDeposit;
use core\entities\payment\PaymentOrder;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class PaymentSearch extends Model
{
    public $id;
    public $order_id;
    public $user_id;
    public $type;
    public $method;
    public $status;

    public function rules()
    {
        return [
            [['id', 'order_id', 'user_id', 'method', 'status'], 'integer'],
            [['type'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Payment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $assignTargetType = function ($relationName) use (&$query) {
            $query->joinWith($relationName)->andWhere(['not', ['payment_id' => null]]);
        };

        if ($this->type === Payment::TYPE_DEPOSIT) {
            $assignTargetType("paymentDeposit");
        }
        if ($this->type === Payment::TYPE_ORDER) {
            $assignTargetType("paymentOrder");
        }

        $query->andFilterWhere([
            'id' => $this->id,
            PaymentDeposit::tableName() . '.user_id' => $this->user_id,
            PaymentOrder::tableName() . '.order_id' => $this->order_id,
            'status' => $this->status,
            'method' => $this->method,
        ]);

        return $dataProvider;
    }

}
