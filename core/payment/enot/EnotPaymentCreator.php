<?php

namespace core\payment\enot;

class EnotPaymentCreator
{
    public const CASHBOX_URL = 'https://enot.io/pay?';

    private $shopId;
    private $firstKey;
    private $sum;
    private $description;
    private $additionalParams;

    public function __construct($shopId, $firstKey, $sum, $description, array $additionalParams = [])
    {
        $this->shopId = $shopId;
        $this->firstKey = $firstKey;
        $this->sum = $sum;
        $this->description = $description;
        $this->additionalParams = $additionalParams;
    }

    public function getPaymentLink()
    {
        $params = [
            'm' => $this->shopId,
            'oa' => $this->sum,
            'o' => $this->description,
            's' => $this->generateSign()
        ];
        $params += $this->additionalParams;

        return self::CASHBOX_URL . http_build_query($params);
    }

    private function generateSign()
    {
        return md5("$this->shopId:$this->sum:$this->firstKey:$this->description");
    }

}