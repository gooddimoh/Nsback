<?php

namespace core\lib\djekxa;

use yii\httpclient\Client;

class DjekxaClient
{
    protected const ENDPOINT = "http://djekxa.ru/api";
    protected const EXISTING_CATEGORIES = [1, 2, 3, 5, 7, 9, 10, 12];

    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getProduct()
    {
        $product = [];

        foreach (self::EXISTING_CATEGORIES as $categoryId) {
            $product = array_merge($this->getProductByCategory($categoryId), $product);
        }

        return $product;
    }

    public function getProductByCategory($categoryId = null)
    {
        if (!in_array((int)$categoryId, self::EXISTING_CATEGORIES, true)) {
            throw new \InvalidArgumentException("Unknown category id");
        }

        return $this->query("product/$categoryId", "GET");
    }

    public function buy($goodId, $count)
    {
        $order = $this->query("buy", "POST", [
            'good_id' => $goodId,
            'count' => $count,
            'apikey' => $this->apiKey,
        ]);


        if (isset($order['error'])) {
            throw new \DomainException($order['error']);
        }
        if (!isset($order['order_id'])) {
            \Yii::info($order, "djekxaEmptyClient");
            throw new \DomainException("Order number is not set.");
        }

        return $order;
    }

    protected function query($relativePath, $method, array $params = [])
    {
        $url = self::ENDPOINT . "/$relativePath";

        $client = new Client();
        $request = $client->createRequest()->setUrl($url)->setMethod($method)->setData($params);

        return $request->send()->data;
    }

}