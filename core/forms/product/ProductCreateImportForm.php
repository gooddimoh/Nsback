<?php

namespace core\forms\product;

use core\entities\shop\Shop;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ProductCreateImportForm extends Model
{
    public $shopId;
    public $shopItemId;

    public function rules()
    {
        return [
            [['shopId', 'shopItemId'], 'required'],
            [['shopId'], 'exist', 'targetClass' => Shop::class, 'targetAttribute' => 'id'],
            [['shopItemId'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'shopId' => 'Магазин',
            'shopItemId' => 'ID Продукта',
        ];
    }

    public function attributeHints()
    {
        return [
            'shopItemId' => 'Нужно взять в магазине поставщика',
        ];
    }

    public static function getShopList()
    {
        return ArrayHelper::map(Shop::find()->all(), "id", 'name');
    }


}