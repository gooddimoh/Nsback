<?php

namespace core\payment\webmoney;

class WebMoneyPayment
{
    private $payeePurse;
    private $paymentAmount;
    private $paymentNo;
    private $mode;
    private $sysInvsNo;
    private $sysTransNo;
    private $sysTransDate;
    private $paymentDesc;
    private $payerPurse;
    private $payerWm;
    private $hold;
    private $hash;

    /**
     * @return mixed
     */
    public function getPayeePurse()
    {
        return $this->payeePurse;
    }

    /**
     * @param mixed $payeePurse
     */
    public function setPayeePurse($payeePurse)
    {
        $this->payeePurse = $payeePurse;
    }

    /**
     * @return mixed
     */
    public function getPaymentAmount()
    {
        return $this->paymentAmount;
    }

    /**
     * @param mixed $paymentAmount
     */
    public function setPaymentAmount($paymentAmount)
    {
        $this->paymentAmount = $paymentAmount;
    }

    /**
     * @return mixed
     */
    public function getPaymentNo()
    {
        return $this->paymentNo;
    }

    /**
     * @param mixed $paymentNo
     */
    public function setPaymentNo($paymentNo)
    {
        $this->paymentNo = $paymentNo;
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @return mixed
     */
    public function getSysInvsNo()
    {
        return $this->sysInvsNo;
    }

    /**
     * @param mixed $sysInvsNo
     */
    public function setSysInvsNo($sysInvsNo)
    {
        $this->sysInvsNo = $sysInvsNo;
    }

    /**
     * @return mixed
     */
    public function getSysTransNo()
    {
        return $this->sysTransNo;
    }

    /**
     * @param mixed $sysTransNo
     */
    public function setSysTransNo($sysTransNo)
    {
        $this->sysTransNo = $sysTransNo;
    }

    /**
     * @return mixed
     */
    public function getSysTransDate()
    {
        return $this->sysTransDate;
    }

    /**
     * @param mixed $sysTransDate
     */
    public function setSysTransDate($sysTransDate)
    {
        $this->sysTransDate = $sysTransDate;
    }

    /**
     * @return mixed
     */
    public function getPayerPurse()
    {
        return $this->payerPurse;
    }

    /**
     * @param mixed $payerPurse
     */
    public function setPayerPurse($payerPurse)
    {
        $this->payerPurse = $payerPurse;
    }

    /**
     * @return mixed
     */
    public function getPayerWm()
    {
        return $this->payerWm;
    }

    /**
     * @param mixed $payerWm
     */
    public function setPayerWm($payerWm)
    {
        $this->payerWm = $payerWm;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getHold()
    {
        return $this->hold;
    }

    /**
     * @param mixed $hold
     */
    public function setHold($hold)
    {
        $this->hold = $hold;
    }

    public function hasHold()
    {
        return $this->hold !== null;
    }

    public function isPaymentSignValid($key)
    {
        return $this->hash == $this->generateCheckSign($key);
    }

    /**
     * @return mixed
     */
    public function getPaymentDesc()
    {
        return $this->paymentDesc;
    }

    /**
     * @param mixed $paymentDesc
     */
    public function setPaymentDesc($paymentDesc)
    {
        $this->paymentDesc = $paymentDesc;
    }

    protected function generateCheckSign($key)
    {
        $signParams = [
            $this->payeePurse,
            $this->paymentAmount,
            $this->paymentNo,
            $this->mode,
            $this->sysInvsNo,
            $this->sysTransNo,
            $this->sysTransDate,
            $key,
            $this->payerPurse,
            $this->payerWm,
        ];

        return strtoupper(hash('sha256', implode('', $signParams)));
    }

}