<?php

namespace core\payment\payeer;


/**
 * @url https://payeer.com/merchant/ips.txt Allowed IP List
 * @url https://docs.google.com/viewer?url=https://www.payeer.com/upload/pdf/PayeerMerchantru.pdf Documentation
 */
class PayeerHandler
{
    const STATUS_SUCCESS = "success";
    const ALLOWED_IP_LIST = [
        '185.71.65.92',
        '185.71.65.189',
        '149.202.17.210',
    ];

    private $payload;
    private $ip;
    private $secret;

    public function __construct(array $payload, $ip, $secret)
    {
        $this->payload = $payload;
        $this->ip = $ip;
        $this->secret = $secret;
    }

    public function check()
    {
        $this->guardIp();
        $this->guardSign();
        $this->guardStatus();
    }

    protected function guardIp()
    {
        if (!$this->validateIp($this->ip)) {
            throw new \InvalidArgumentException("Not allowed IP");
        }
    }

    protected function validateIp($ip)
    {
        return in_array($ip, self::ALLOWED_IP_LIST);
    }

    protected function guardSign()
    {
        if (!$this->validateSign($this->payload['m_sign'])) {
            throw new \InvalidArgumentException("Incorrect sign");
        }
    }

    protected function validateSign($sign)
    {
        return $this->generateSign() === $sign;
    }

    protected function generateSign()
    {
        $data = [
            $this->payload['m_operation_id'],
            $this->payload['m_operation_ps'],
            $this->payload['m_operation_date'],
            $this->payload['m_operation_pay_date'],
            $this->payload['m_shop'],
            $this->payload['m_orderid'],
            $this->payload['m_amount'],
            $this->payload['m_curr'],
            $this->payload['m_desc'],
            $this->payload['m_status']
        ];

        if (isset($data['m_params'])) {
            $data[] = $data['m_params'];
        }

        $data[] = $this->secret;

        return strtoupper(hash('sha256', implode(':', $data)));
    }

    protected function guardStatus()
    {
        if (!$this->validateStatus($this->payload['m_status'])) {
            throw new \InvalidArgumentException("Status must be " . self::STATUS_SUCCESS);
        }
    }

    protected function validateStatus($status)
    {
        return $status === self::STATUS_SUCCESS;
    }

    public function getSign()
    {
        return $this->generateSign();
    }

}