<?php

namespace backend\forms\product;

use core\entities\product\Category;
use core\entities\product\Group;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class GroupSearch extends Model
{
    public $id;
    public $name;
    public $category_id;

    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name'], 'string', 'max' => 246],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'category_id' => 'Группа',
        ];
    }

    public function search($params)
    {
        $query = Group::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['position' => SORT_ASC]],
            'pagination' => [
                'pageSizeLimit' => [1, 500],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public static function getCategoryList()
    {
        return ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name');
    }

}
