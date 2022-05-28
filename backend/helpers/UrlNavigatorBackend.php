<?php

namespace backend\helpers;

class UrlNavigatorBackend
{

    public static function viewUser($id)
    {
        return ['/user/view', 'id' => $id];
    }

    public static function viewOrder($id)
    {
        return ['/finance/order/view', 'id' => $id];
    }

    public static function viewPayment($id)
    {
        return ['/finance/payment/view', 'id' => $id];
    }

    public static function viewProduct($id)
    {
        return ['/product/product/view', 'id' => $id];
    }

    public static function viewOrderSecure($code, $email)
    {
        return ['/finance/order/view', 'code' => $code, 'email' => $email];
    }

    public static function viewShop($id)
    {
        return ['/shop/shop/view', 'id' => $id];
    }

    public static function viewGroup($id)
    {
        return ['/product/group/view', 'id' => $id];
    }

    public static function viewCategory($id)
    {
        return ['/product/category/view', 'id' => $id];
    }

}