<?php

namespace backend\forms\product;

use core\entities\product\Category;
use core\entities\product\Product;
use core\entities\product\Group;
use core\entities\product\property\ProductProperty;
use core\entities\product\property\PropertyTrait;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;


class IncompleteProductSearch extends Model
{
    public $empty_miniature;
    public $empty_description;

    public $group_id;
    public $category_id;
    public $status;

    public $empty_properties;

    public function rules()
    {
        return [
            [['empty_miniature', 'empty_description'], 'boolean'],
            [['empty_properties'], 'boolean'],
            [['status', 'group_id', 'category_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'empty_miniature' => 'Пустая миниатюра',
            'empty_description' => 'Пустое описание',
            'empty_properties' => 'Нет свойств',
            'status' => 'Статус',
            'category_id' => 'Категория',
            'group_id' => 'Группа',
        ];
    }

    public function search($params)
    {
        $query = Product::find()->joinWith(['properties', 'group']);

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

        $query->andFilterWhere([
            'status' => $this->status,
            'group_id' => $this->group_id,
            'category_id' => $this->category_id,
        ]);

        $nullExpression = new \yii\db\Expression('null');

        if ($this->empty_miniature) {
            $query->andFilterWhere(['IS', 'miniature', $nullExpression]);
        }
        if ($this->empty_description) {
            $query->andFilterWhere(['IS', 'description', $nullExpression]);
        }
        if ($this->empty_properties) {
            $query->andWhere(['IS', ProductProperty::tableName() . '.id', $nullExpression]);
        }

        return $dataProvider;
    }

    public static function getCategoryList()
    {
        return ArrayHelper::map(Category::find()->all(), 'id', 'name');
    }

    public static function getGroupList()
    {
        return ArrayHelper::map(Group::find()->all(), 'id', 'name');
    }

}
