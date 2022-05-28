<?php

namespace core\settings\storage;

use core\settings\SettingsStorage;

class PayeerSettings implements PaymentSystemInterface
{
    private $settingsRepository;

    private $merchantId;
    private $secret;

    private $description;
    private $disable;


    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;

        $this->merchantId = $this->get("merchantId");
        $this->secret = $this->get("secret");

        $this->description = $this->get('description');
        $this->disable = $this->get('disable');
    }

    private function get($key)
    {
        return $this->settingsRepository->get(SettingsStorage::GROUP_PAYEER, $key);
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function getName()
    {
        return "Payeer";
    }

    public function getIconPath()
    {
        return "/img/icons/payments/payeer.png";
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function isDisabled()
    {
        return $this->disable;
    }


    public function getWarning()
    {
        return null;
    }
}