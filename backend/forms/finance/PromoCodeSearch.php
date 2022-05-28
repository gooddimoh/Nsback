<?php

namespace backend\forms\finance;

use core\entities\order\PromoCode;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PromoCodeSearch extends Model
{
    public $id;
    public $user_id;
    public $code;
    public $sum;
    public $status;

    public function rules()
    {
        return [
            [['id', 'status', 'user_id'], 'integer'],
            [['sum'], 'number'],
            [['code'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Активация',
            'code' => 'Промо-код',
            'sum' => 'Сумма',
            'status' => 'Статус',
        ];
    }

    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PromoCode::find()->where(['!=', 'status', PromoCode::STATUS_REMOVED]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sum' => $this->sum,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }

}
