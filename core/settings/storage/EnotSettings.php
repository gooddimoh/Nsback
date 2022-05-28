<?php

namespace core\settings\storage;

use core\settings\SettingsStorage;

class EnotSettings implements PaymentSystemInterface
{
    private $merchantId;
    private $firstSecret;
    private $secondSecret;
    private $description;
    private $disable;

    private $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
        $this->merchantId = $this->get('merchantId');
        $this->firstSecret = $this->get('firstSecret');
        $this->secondSecret = $this->get('secondSecret');
        $this->description = $this->get('description');
        $this->disable = $this->get('disable');
    }

    /**
     * @return mixed|null
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @return mixed|null
     */
    public function getFirstSecret()
    {
        return $this->firstSecret;
    }

    /**
     * @return mixed|null
     */
    public function getSecondSecret()
    {
        return $this->secondSecret;
    }

    public function getName()
    {
        return "Enot.io";
    }

    public function getIconPath()
    {
        return "/img/icons/payments/enot.png";
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function isDisabled()
    {
        return (bool) $this->disable;
    }

    private function get($key)
    {
        return $this->settingsRepository->get(SettingsStorage::GROUP_ENOT, $key);
    }

    public function getWarning()
    {
        return null;
    }

}