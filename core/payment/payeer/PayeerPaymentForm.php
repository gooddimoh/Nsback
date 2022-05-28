<?php

namespace core\payment\payeer;

use core\settings\storage\PayeerSettings;

class PayeerPaymentForm
{
    const ENDPOINT = "https://payeer.com/merchant/";

    private $settings;

    private $merchantId;
    private $action;
    private $paymentId;
    private $amount;
    private $description;
    private $currency;
    private $sign;
    private $params = [];

    public function __construct(PayeerSettings $settings, $paymentId, $amount, $description, $currency = "RUB")
    {
        $this->action = self::ENDPOINT;

        $this->settings = $settings;

        $this->merchantId = $settings->getMerchantId();
        $this->paymentId = $paymentId;
        $this->amount = number_format($amount, 2, '.', '');
        $this->description = base64_encode($description);
        $this->currency = $currency;
        $this->sign = $this->generateSign();
    }

    protected function generateSign()
    {
        $data = [$this->settings->getMerchantId(),
            $this->paymentId,
            $this->amount,
            $this->currency,
            $this->description,
            $this->settings->getSecret()];

        return strtoupper(hash('sha256', implode(":", $data)));
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed|string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @return mixed|null
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    public function setSuccessUrl($url)
    {
        $this->params['success_url'] = $url;
    }

    public function setFailUrl($url)
    {
        $this->params['fail_url'] = $url;
    }

    public function getParams()
    {
        return $this->params;
    }


}