<?php

namespace core\payment\lava;

use core\payment\lava\exceptions\ApiException;
use yii\httpclient\Client;

class LavaClient
{
    const ENDPOINT = "https://api.lava.ru";

    private $jwtToken;

    public function __construct($jwtToken)
    {
        $this->jwtToken = $jwtToken;
    }

    public function createInvoice(Invoice $invoice)
    {
        return $this->query("/invoice/create", [
            'wallet_to' => $invoice->getWalletTo(),
            'sum' => $invoice->getSum(),
            'order_id' => $invoice->getOrderId(),
            'hook_url' => $invoice->getHookUrl(),
            'success_url' => $invoice->getSuccessUrl(),
            'fail_url' => $invoice->getFailUrl(),
            'expire' => $invoice->getExpire(),
            'subtract' => $invoice->getSubtract(),
            'custom_fields' => $invoice->getCustomFields(),
            'comment' => $invoice->getComment(),
        ]);
    }

    protected function query($link, array $params = [])
    {
        $client = new Client();

        $response = $client->createRequest()
            ->setUrl(self::ENDPOINT . $link)
            ->setData($params)
            ->addHeaders(['Authorization' =>  $this->jwtToken])
            ->setMethod("POST")
            ->send();
        \Yii::info($response->data);

        if (!$response->getIsOk() || !isset($response->data['status']) || $response->data['status'] !== "success") {
            throw new ApiException(
                isset($response->data['message']) ? $response->data['message'] : "An error occurred when requesting API",
                isset($response->data['code']) ? $response->data['code'] : $response->getStatusCode()
            );
        }

        return $response->data;
    }

    public function infoInvoice($id, $orderId)
    {
        $payload =  $this->query("/invoice/info", [
            'id' => $id,
            'orderId' => $orderId,
        ]);

        return new InvoiceInfo($payload['invoice']);
    }

}