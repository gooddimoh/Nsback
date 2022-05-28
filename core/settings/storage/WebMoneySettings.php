<?php

namespace core\settings\storage;

use core\settings\SettingsStorage;

class WebMoneySettings implements PaymentSystemInterface
{
    private $rWallet;
    private $rKey;
    private $description;
    private $disable;

    private $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;

        $this->rWallet = $this->get('rWallet');
        $this->rKey = $this->get('rKey');
        $this->description = $this->get('description');
        $this->disable = $this->get('disable');
    }

    /**
     * @return mixed|null
     */
    public function getRWallet()
    {
        return $this->rWallet;
    }

    /**
     * @return mixed|null
     */
    public function getRKey()
    {
        return $this->rKey;
    }

    public function getName()
    {
        return "WebMoney";
    }

    public function getIconPath()
    {
        return "/img/icons/payments/webmoney.png";
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
        return $this->settingsRepository->get(SettingsStorage::GROUP_WEB_MONEY, $key);
    }


    public function getWarning()
    {
        return null;
    }
}