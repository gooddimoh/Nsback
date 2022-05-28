<?php

namespace core\payment\enot;

use core\payment\common\PaymentHelper;

class EnotPaymentHandler
{
    private $key;

    public static function aliasParamsMap()
    {
        return [
            'merchant' => 'merchantId',
            'amount' => 'sum',
            'sign_2' => 'sign',
            'intid' => 'operationId',
            'merchant_id' => 'description',
        ];
    }

    /**
     * @var EnotPayment
     */
    private $enotPayment;

    public function __construct($apiKey, array $data)
    {
        $enotPayment = new EnotPayment();
        $this->key = $apiKey;

        PaymentHelper::renameLabelsByAliases($data, self::aliasParamsMap());

        foreach ($data as $key => $value) {
            $enotPayment->$key = $value;
        }

        $this->enotPayment = $enotPayment;
    }

    public function signValidation()
    {
        return $this->generateSign() === $this->enotPayment->sign;
    }

    private function generateSign()
    {
        $signParams = [
            $this->enotPayment->merchantId,
            $this->enotPayment->sum,
            $this->key,
            $this->enotPayment->description
        ];

        return md5(implode(':', $signParams));
    }

    /**
     * @return EnotPayment
     */
    public function getEnotPayment()
    {
        return $this->enotPayment;
    }

}