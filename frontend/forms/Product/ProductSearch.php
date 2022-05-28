<?php

namespace frontend\forms\Product;

use core\entities\product\Category;
use core\entities\product\Product;
use core\entities\product\Group;
use core\entities\product\property\PropertyTrait;
use core\lib\emoji\Emoji;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProductSearch extends Model
{
    use PropertyTrait;

    const SEARCH_TRIGGERED_PARAM = "search_triggered";

    public $name;
    public $category_id;
    public $group_id;
    public $group_slug;
    public $price_from;
    public $price_to;

    public $show_not_available = "";

    private $belong_group_id;
    private $excluded_ids = [];
    private $orderBy = ['price' => SORT_ASC];
    private $defaultPageSize = 7;

    public function rules()
    {
        return [
            [['group_id', 'category_id'], 'integer'],
            [['price_from', 'price_to'], 'number'],
            [['name'], 'string', 'max' => 246],
            [['show_not_available'], 'string'],
            [['group_slug'], 'safe'],
            [['excluded_ids'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'group_id' => 'Группа',
            'price_from' => 'Цена от',
            'price_to' => 'Цена до',
            'show_not_available' => 'Есть в наличии',
            'category_id' => 'Категория',
        ];
    }

    public function setSortByTop()
    {
        return $this->orderBy = ['is_top' => SORT_DESC];
    }

    public function setDefaultPageSize($defaultPageSize)
    {
        $this->defaultPageSize = $defaultPageSize;
    }

    public function search($params)
    {
        $query = Product::find()
            ->where(['status' => Product::PUBLIC_STATUS])
            ->limit(5)
            ->joinWith(['group.category'])
            ->distinct();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => $this->orderBy],
            'pagination' => [
                'pageSizeLimit' => [1, 150],
                'defaultPageSize' => $this->defaultPageSize,
            ],
        ]);

        $this->load($params, '');
        if (!$this->validate()) {
            return $dataProvider;
        }

        if (is_array($this->excluded_ids) && !empty($this->excluded_ids)) {
            $query->andFilterWhere(['NOT IN', Product::tableName() . '.id', $this->excluded_ids]);
        }

        $groupIds = [];
        if ($this->group_id) {
            $groupIds[] = $this->group_id;
        }
        if ($this->belong_group_id) {
            $groupIds[] = $this->belong_group_id;
        }

        $query->andFilterWhere([
            'group_id' => $groupIds,
            'category_id' => $this->category_id,
            Group::tableName() . '.slug' => $this->group_slug,
        ]);
        if ($this->properties) {
            $query->joinWith('properties');
            $query->andFilterWhere(['property_id' => $this->properties]);
        }

        if (!$this->show_not_available) {
            $query->andFilterWhere([">", "quantity", 0]);
        }

        $query->andFilterWhere(['like', Product::tableName() . '.name', $this->name])
            ->andFilterWhere(['>=', 'price', $this->price_from ?: null])
            ->andFilterWhere(['<=', 'price', $this->price_to ?: null]);

        return $dataProvider;
    }

    public function setExcludedIds($excludedIds)
    {
        $this->excluded_ids = $excludedIds;
    }

    public function setBelongGroupId($groupId)
    {
        $this->belong_group_id = $groupId;
        return $this;
    }

    public static function getCategoryList()
    {
        return Category::find()->all();
    }

    public static function getSortList()
    {
        return [
            ['value' => 'price', 'name' => 'Дешевле'],
            ['value' => '-price', 'name' => 'Дороже'],
            ['value' => 'name', 'name' => 'Название[А-Я]'],
            ['value' => '-name', 'name' => 'Название[Я-А]'],
            ['value' => 'purchase_counter', 'name' => 'Кол-во покупок ' . Emoji::C_UPWARDS_BLACK_ARROW],
            ['value' => '-purchase_counter', 'name' => 'Кол-во покупок ' . Emoji::C_DOWNWARDS_BLACK_ARROW],
        ];
    }


}
