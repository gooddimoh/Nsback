<?php

namespace core\payment\coinbase;

use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Charge;

class CoinbasePayment
{
    public $receipt;

    public function __construct($key)
    {
        ApiClient::init($key);
    }

    public function create($name, $description, $price, $currency = 'RUB', array $metaData = [], $redirectUrl = null, $cancelUrl = null)
    {
        $charge = new Charge();
        $charge->name = $name;
        $charge->description = $description;
        $charge->local_price = [
            'amount' => $price,
            'currency' => $currency
        ];
        $charge->redirect_url = $redirectUrl;
        $charge->cancel_url = $cancelUrl;
        $charge->pricing_type = 'fixed_price';
        $charge->metadata = $metaData;
        try {
            $charge->save();
            $retrievedCharge = Charge::retrieve($charge->id);
            return $retrievedCharge->hosted_url;
        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());
        }
    }

}