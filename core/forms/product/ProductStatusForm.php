<?php

namespace core\forms\product;

use core\entities\product\Product;
use core\helpers\product\ProductHelper;
use yii\base\Model;
use yii\helpers\Html;

class ProductStatusForm extends Model
{
    const ALLOWED_STATUS_LIST = [Product::STATUS_ACTIVE, Product::STATUS_BLOCKED, Product::STATUS_HIDDEN, Product::STATUS_MODERATION];

    public $status;

    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'in', 'range' => self::ALLOWED_STATUS_LIST]
        ];
    }

    public function attributeLabels()
    {
        return [
            'status' => 'Статус',
        ];
    }

    public function attributeHints()
    {
        return [
            'status' => 'Чтобы понять назначение статусов - ' . Html::a("используйте справку", ['/help/order'])
        ];
    }

    public static function getStatusList()
    {
        return array_filter(ProductHelper::statusList(), function ($value, $key) {
            return in_array($key, self::ALLOWED_STATUS_LIST);
        }, ARRAY_FILTER_USE_BOTH);
    }


}