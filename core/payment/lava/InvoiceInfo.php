<?php

namespace core\payment\lava;

use Webmozart\Assert\Assert;

class InvoiceInfo extends Invoice
{
    protected $id;
    protected $status;

    public function __construct(array $payload)
    {
        Assert::keyExists($payload, "id");
        Assert::keyExists($payload, "order_id");
        Assert::keyExists($payload, "expire");
        Assert::keyExists($payload, "sum");
        Assert::keyExists($payload, "comment");
        Assert::keyExists($payload, "status");
        Assert::keyExists($payload, "success_url");
        Assert::keyExists($payload, "fail_url");
        Assert::keyExists($payload, "hook_url");
        Assert::keyExists($payload, "custom_fields");

        $this->id = $payload['id'];
        $this->orderId = $payload['order_id'];
        $this->expire = $payload['expire'];
        $this->sum = $payload['sum'];
        $this->comment = $payload['comment'];
        $this->status = $payload['status'];
        $this->successUrl = $payload['success_url'];
        $this->failUrl = $payload['fail_url'];
        $this->hookUrl = $payload['hook_url'];
        $this->customFields = $payload['custom_fields'];
    }

    public function isSuccess()
    {
        return $this->status === Status::STATUS_SUCCESS;
    }

}