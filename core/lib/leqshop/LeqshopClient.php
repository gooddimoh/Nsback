<?php

namespace core\lib\leqshop;

use yii\httpclient\Client;

class LeqshopClient
{
    public const IP_API_SERVER = "http://95.182.120.45:83";

    private $shopDomain;

    private $apiKeyPublic;
    private $apiKeyPrivate;


    private $client;

    public function __construct($shopDomain, $apiKeyPublic, $apiKeyPrivate, Client $client)
    {
        $this->client = $client;
        $this->shopDomain = $shopDomain;
        $this->apiKeyPublic = $apiKeyPublic;
        $this->apiKeyPrivate = $apiKeyPrivate;
    }

    public function getProduct($apiProductKey)
    {
        $product = $this->query("api/product", 'GET', ['key' => $apiProductKey]);
        if (!isset($product['product'])) {
            throw new \DomainException("Product not set");
        }

        return $product['product'];
    }

    /**
     * @param $email
     * @param $createOrderKey
     * @param $userToken
     * @param $count
     * @param $itemId
     * @param null $coupon
     * @return mixed
     * @throws ApiException
     */
    public function createOrderByBalance($email, $createOrderKey, $userToken, $count, $itemId, $coupon = null)
    {
        $invoice = $this->hardQuery("api/createorder", true, [
            'email' => $email,
            'key' => $createOrderKey,
            'count' => $count,
            'type' => $itemId,
            'fund' => 13,
            'token_pay' => $userToken,
            'copupon' => $coupon, // You might think "copupon" is typo. No, these are realities Leqshop
        ]);

        if (isset($invoice['error'])) {
            ErrorReader::throw($invoice['error']); // Determinate Exception what must be thrown
        }

        if (isset($invoice['invoice'])) {
            $paidInvoice = $this->hardQuery("api/paybalance/{$invoice['invoice']}", true, [
                'pay' => 'yes',
                'email_pay' => $email,
                'token_pay' => $userToken,
            ]);
            if (isset($paidInvoice['invoice'])) {
                return $paidInvoice['invoice'];
            }

            throw new ApiException("Failed to pay invoice {$invoice['invoice']}");
        }

        throw new ApiException("Invoice not set. Body: " . json_encode($invoice));
    }

    public function download($invoice)
    {
        return $this->hardQuery("api/downloadtxt/$invoice", false);
    }

    protected function query($relativePath, $method, array $params = [])
    {
        $endpointUrl = rtrim(self::IP_API_SERVER, "/") . "/" . $relativePath;
        $userAgent = "PlatformerLeque";
        $headers = [
            'LEQUE-KEY-API-PUB' => $this->apiKeyPublic,
            'LEQUE-KEY-API-PRIV' => $this->apiKeyPrivate,
            'User-Agent' => $userAgent,
            'Host' => $this->shopDomain,
        ];
        $request = $this->client->createRequest()
            ->setUrl($endpointUrl)
            ->setMethod($method)
            ->setOptions(['userAgent' => $userAgent])
            ->setData($params)
            ->setHeaders($headers);

        return $request->send()->data;
    }

    protected function hardQuery($relativePath, $mustJson = true, array $params = [])
    {
        $relativePath = trim($relativePath, "/");
        $ipApiServer = rtrim(self::IP_API_SERVER);
        $ch = curl_init("$ipApiServer/$relativePath");
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "PlatformerLeque",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => array(
                'LEQUE-KEY-API-PUB:' . $this->apiKeyPublic,
                'LEQUE-KEY-API-PRIV:' . $this->apiKeyPrivate,
                'HOST:' . $this->shopDomain,
            ),
        ));

        $response = curl_exec($ch);
        curl_close($ch);


        if ($mustJson) {
            $result = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ApiException("Response not JSON: $response");
            }
        } else {
            $result = $response;
        }

        return $result;
    }
}