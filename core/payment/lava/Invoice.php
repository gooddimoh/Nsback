<?php

namespace core\payment\lava;

abstract class Invoice
{

    protected $sum;
    protected $orderId;
    protected $hookUrl;
    protected $successUrl;
    protected $failUrl;
    protected $expire;
    protected $customFields;
    protected $comment;

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param mixed $sum
     * @return Invoice
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     * @return Invoice
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHookUrl()
    {
        return $this->hookUrl;
    }

    /**
     * @param mixed $hookUrl
     * @return Invoice
     */
    public function setHookUrl($hookUrl)
    {
        $this->hookUrl = $hookUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSuccessUrl()
    {
        return $this->successUrl;
    }

    /**
     * @param mixed $successUrl
     * @return Invoice
     */
    public function setSuccessUrl($successUrl)
    {
        $this->successUrl = $successUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFailUrl()
    {
        return $this->failUrl;
    }

    /**
     * @param mixed $failUrl
     * @return Invoice
     */
    public function setFailUrl($failUrl)
    {
        $this->failUrl = $failUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * @param mixed $expire
     * @return Invoice
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     * @param mixed $customFields
     * @return Invoice
     */
    public function setCustomFields($customFields)
    {
        $this->customFields = $customFields;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     * @return Invoice
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }


}