<?php

namespace core\payment\freekassa;

class FreekassaPaymentCreator
{
    const CASHBOX_URL = 'https://pay.freekassa.ru/';
    const ALLOWED_CURRENCIES = ['RUB', 'USD', 'EUR', 'UAH', 'KZT'];

    private $shopId;
    private $firstKey;
    private $sum;
    private $description;
    private $currency;
    private $additionalParams;

    public function __construct($shopId, $firstKey, $sum, $description, $currency, array $additionalParams = [])
    {
        if (!in_array($currency, self::ALLOWED_CURRENCIES)) {
            throw new \LogicException("Not supported currency");
        }

        $this->shopId = $shopId;
        $this->firstKey = $firstKey;
        $this->sum = $sum;
        $this->description = $description;
        $this->currency = $currency;
        $this->additionalParams = $additionalParams;
    }

    public function getPaymentLink()
    {
        $params = [
            'm' => $this->shopId,
            'oa' => $this->sum,
            'currency' => $this->currency,
            'o' => $this->description,
            's' => $this->generateSign()
        ];
        $params += $this->additionalParams;

        return self::CASHBOX_URL . "?" . http_build_query($params);
    }

    private function generateSign()
    {
        return md5("$this->shopId:$this->sum:$this->firstKey:$this->currency:$this->description");
    }

}