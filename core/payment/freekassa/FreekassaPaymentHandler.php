<?php

namespace core\payment\freekassa;


class FreekassaPaymentHandler
{
    private $key;

    public static function aliasParamsMap()
    {
        return [
            'MERCHANT_ID' => 'merchantId',
            'AMOUNT' => 'sum',
            'SIGN' => 'sign',
            'intid' => 'operationId',
            'MERCHANT_ORDER_ID' => 'description',
            'CUR_ID' => 'currency',
        ];
    }

    /**
     * @var FreekassaPayment
     */
    private $freekassaPayment;

    public static function availableIpList()
    {
        return ["168.119.157.136", "168.119.60.227", "138.201.88.124", "178.154.197.79"];
    }

    public function __construct($key, array $data)
    {
        $freekassaPayment = new FreekassaPayment();
        $this->key = $key;

        PaymentHelper::renameLabelsByAliases($data, self::aliasParamsMap());

        foreach ($data as $key => $value) {
            $freekassaPayment->$key = $value;
        }

        $this->freekassaPayment = $freekassaPayment;
    }

    public function isIpAllowed($ip)
    {
        return in_array($ip, self::availableIpList());
    }

    public function signValidation()
    {
        return $this->generateSign() === $this->freekassaPayment->sign;
    }

    private function generateSign()
    {
        $signParams = [
            $this->freekassaPayment->merchantId,
            $this->freekassaPayment->sum,
            $this->key,
            $this->freekassaPayment->description
        ];

        return md5(implode(':', $signParams));
    }

    /**
     * @return FreekassaPayment
     */
    public function getFreekassaPayment()
    {
        return $this->freekassaPayment;
    }

}