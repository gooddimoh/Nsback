<?php

namespace core\payment\qiwiInvoice;

class QiwiP2P
{
    const PAY_SOURCE_FILTER_QIWI = "qw";
    const PAY_SOURCE_FILTER_CARD = "card";

    public $publicKey;
    public $privateKey;

    public $themeCode = "fedor-b4T1VNtRPb";

    public function __construct($publicKey, $privateKey)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    public function createPaymentUrl($amount, $accountId, $description, $successUrl, array $paySource = [])
    {
        $customFields = [];
        $customFields['paySourcesFilter'] = $paySource ? rtrim(implode(",", $paySource), ",") : null;

        if ($this->themeCode) {
            $customFields['themeCode'] = $this->themeCode; // Не должно быть null, иначе другие опции не сработают
        }

        $params = [
            'publicKey' => $this->publicKey,
            'amount' => number_format(round(floatval($amount), 2, PHP_ROUND_HALF_DOWN), 2, '.', ''),
            'billId' => md5(time() . rand()),
            'account' => $accountId,
            'comment' => $description,
            'successUrl' => $successUrl,
            'customFields' => $customFields,
        ];

        return "https://oplata.qiwi.com/create" . '?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);
    }

    public function handleSuccessRubPayment($validSignatureFromNotificationServer, $notificationBody)
    {
        $this->handleRequest($validSignatureFromNotificationServer, $notificationBody);

        if ($notificationBody['bill']['amount']['currency'] !== "RUB") {
            throw new \DomainException("Not acceptable payment currency");
        }

        if ($notificationBody['bill']['status']['value'] !== "PAID") {
            throw new \DomainException("Not acceptable payment status");
        }
    }

    public function handleRequest($validSignatureFromNotificationServer, $notificationBody)
    {
        $processedNotificationData = [
            'billId' => (string)$notificationBody['bill']['billId'],
            'amount.value' => number_format(round(floatval($notificationBody['bill']['amount']['value']), 2, PHP_ROUND_HALF_DOWN), 2, '.', ''),
            'amount.currency' => (string)$notificationBody['bill']['amount']['currency'],
            'siteId' => (string)$notificationBody['bill']['siteId'],
            'status' => (string)$notificationBody['bill']['status']['value'],
        ];
        ksort($processedNotificationData);
        $processedNotificationDataKeys = join('|', $processedNotificationData);
        $hash = hash_hmac("sha256", $processedNotificationDataKeys, $this->privateKey);

        if (!$hash === $validSignatureFromNotificationServer) {
            throw new \InvalidArgumentException("Invalid hash");
        }
    }


}