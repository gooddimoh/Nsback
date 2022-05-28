<?php

namespace backend\forms\shop;

use core\entities\shop\Coupon;
use core\entities\shop\Shop;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class CouponSearch extends Model
{
    public $id;
    public $shop_id;
    public $code;
    public $comment;

    public function rules()
    {
        return [
            [['id', 'shop_id'], 'integer'],
            [['code', 'comment'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Coupon::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'shop_id' => $this->shop_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

    public static function shopList()
    {
        return ArrayHelper::map(Shop::findPlatform(), 'id', 'name');
    }

}
