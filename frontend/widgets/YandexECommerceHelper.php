<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class YandexECommerceHelper extends Widget
{

    public static function viewProduct($name, $id, $price, $category)
    {
        $data = ['ecommerce' =>
            ['detail' => ['products' => [
                [
                    'name' => $name,
                    'id' => $id,
                    'price' => $price,
                    'category' => $category
                ]
            ]]]];
        return self::push($data);
    }

    public static function addToCartProduct($id, $name, $price, $quantity, $category)
    {
        $data = ['ecommerce' => [
            'add' => ['products' => [
                [
                    'id' => $id,
                    'name' => $name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'category' => $category,
                ]
            ]]]];
        return self::push($data);
    }

    public static function purchase($orderId, $revenue, $productId, $name, $price, $category)
    {
        $data = ['ecommerce' => [
                'purchase' => [
                    'actionField' => ['id' => $orderId, 'revenue' => $revenue],
                    'products' => [
                        [
                            'id' => $productId,
                            'name' => $name,
                            'price' => $price,
                            'category' => $category,
                        ]
                    ]
                ]
            ]
        ];
        return self::push($data);
    }

    protected static function push(array $data)
    {
        $result = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        return "dataLayer.push($result)";
    }

}