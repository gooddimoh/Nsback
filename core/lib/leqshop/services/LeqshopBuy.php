<?php

namespace core\lib\leqshop\services;

use core\entities\order\Order;
use core\entities\shop\Coupon;
use core\lib\productProvider\BuyInterface;
use core\lib\leqshop\CouponNotValidException;
use core\lib\leqshop\LeqshopClient;
use yii\httpclient\Client;

class LeqshopBuy implements BuyInterface
{
    public function buy(Order $order)
    {
        $shop = $order->product->productImport->shop;
        $coupons = array_map(function (Coupon $coupon) {
            return $coupon->code;
        }, $shop->getCouponsSortedByPercent());

        return $this->createOrder($order, $coupons);
    }

    protected function createOrder(Order $order, array $coupons = [])
    {
        $coupon = array_shift($coupons);

        try {
            $client = self::makeClient($order);
            $product = $order->product;
            $leq = $order->product->productImport->shop->leqshop;

            return $client->createOrderByBalance($leq->user_email,
                $leq->create_order_key,
                $leq->user_token,
                $order->quantity,
                $product->productImport->shop_item_id,
                $coupon);
        } catch (CouponNotValidException $exception) {
            return $this->createOrder($order, $coupons);
        } catch (\Exception $exception) {
            throw new \DomainException($exception->getMessage());
        }
    }

    public function download(Order $order)
    {
        $client = self::makeClient($order);
        return $client->download($order->invoice_id);
    }

    protected static function makeClient(Order $order)
    {
        if (empty($order->product->productImport->shop->leqshop)) {
            throw new \RuntimeException("Order has wrong provider");
        }
        $leq = $order->product->productImport->shop->leqshop;
        return new LeqshopClient($leq->domain, $leq->api_key_public, $leq->api_key_private, new Client());
    }

}