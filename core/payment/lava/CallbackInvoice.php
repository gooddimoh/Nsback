<?php

namespace core\payment\lava;

use Webmozart\Assert\Assert;

class CallbackInvoice
{

    private $type;
    private $invoiceId;
    private $orderId;
    private $status;
    private $payTime;
    private $amount;
    private $customFields;

    public function __construct(array $payload)
    {
        Assert::keyExists($payload, "type");
        Assert::keyExists($payload, "invoice_id");
        Assert::keyExists($payload, "order_id");
        Assert::keyExists($payload, "status");
        Assert::keyExists($payload, "pay_time");
        Assert::keyExists($payload, "amount");

        $this->type = $payload['type'];
        $this->invoiceId = $payload['invoice_id'];
        $this->orderId = $payload['order_id'];
        $this->status = $payload['status'];
        $this->payTime = $payload['pay_time'];
        $this->amount = $payload['amount'];

        if (isset($payload['custom_fields'])) {
            $this->customFields = $payload['custom_fields'];
        }
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function isStatusSuccess()
    {
        return $this->status === Status::STATUS_SUCCESS;
    }

    /**
     * @return mixed
     */
    public function getPayTime()
    {
        return $this->payTime;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }


}