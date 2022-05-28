<?php

namespace core\payment\lava;

class InvoiceCreate extends Invoice
{
    const SUBTRACT_CUSTOMER = 1;
    const SUBTRACT_MERCHANT = 2;

    protected $walletTo;
    protected $subtract;

    public function __construct($walletTo, $sum, $subtract)
    {
        $this->walletTo = $walletTo;
        $this->sum = $sum;
        $this->subtract = $subtract;
    }

    /**
     * @return mixed
     */
    public function getWalletTo()
    {
        return $this->walletTo;
    }

    /**
     * @param mixed $walletTo
     * @return Invoice
     */
    public function setWalletTo($walletTo)
    {
        $this->walletTo = $walletTo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubtract()
    {
        return $this->subtract;
    }

    /**
     * @param mixed $subtract
     * @return Invoice
     */
    public function setSubtract($subtract)
    {
        $this->subtract = $subtract;
        return $this;
    }



}