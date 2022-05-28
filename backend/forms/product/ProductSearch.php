<?php

namespace backend\forms\product;

use core\entities\product\Product;
use core\entities\product\property\PropertyTrait;
use core\entities\shop\Shop;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;


class ProductSearch extends Model
{
    public $id;
    public $name;
    public $description;
    public $status;
    public $group_id;
    public $shop_id;
    public $properties = [];

    use PropertyTrait;

    public function rules()
    {
        return [
            [['id', 'status', 'group_id', 'shop_id'], 'integer'],
            [['name', 'description'], 'string'],
            [['properties'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'status' => 'Статус',
            'group_id' => 'Группа',
            'shop_id' => 'Магазин',
        ];
    }

    public function search($params)
    {
        $query = Product::find()->where(['!=', Product::tableName() . '.status', Product::STATUS_DELETED]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSizeLimit' => [1, 500],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->shop_id) {
            $query->joinWith('productImport.shop');
            $query->andFilterWhere(['shop_id' => $this->shop_id]);
        }
        if ($this->properties) {
            $query->joinWith('properties');
            $query->andFilterWhere(['property_id' => $this->properties]);
        }

        $query->andFilterWhere([
            Product::tableName() . '.id' => $this->id,
            Product::tableName() . '.status' => $this->status,
            Product::tableName() . '.group_id' => $this->group_id,
        ]);

        $query->andFilterWhere(['like', Product::tableName() . '.name', $this->name]);
        $query->andFilterWhere(['like', Product::tableName() . '.description', $this->description]);

        return $dataProvider;
    }

    public static function getShopList()
    {
        return ArrayHelper::map(Shop::find()->asArray()->all(), 'id', 'name');
    }

}
