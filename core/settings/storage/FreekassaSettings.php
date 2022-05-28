<?php

namespace core\settings\storage;

use core\settings\SettingsStorage;

class FreekassaSettings implements PaymentSystemInterface
{
    private $shopId;
    private $firstKey;
    private $secondKey;
    private $description;
    private $disable;

    private $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
        $this->shopId = $this->get('shopId');
        $this->firstKey = $this->get('firstKey');
        $this->secondKey = $this->get('secondKey');
        $this->description = $this->get('description');
        $this->disable = $this->get('disable');
    }

    /**
     * @return mixed|null
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @return mixed|null
     */
    public function getFirstKey()
    {
        return $this->firstKey;
    }

    /**
     * @return mixed|null
     */
    public function getSecondKey()
    {
        return $this->secondKey;
    }

    public function getName()
    {
        return "Freekassa";
    }

    public function getIconPath()
    {
        return "/img/icons/payments/freekassa.png";
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
        return $this->settingsRepository->get(SettingsStorage::GROUP_FREEKASSA, $key);
    }

    public function getWarning()
    {
        return "FKWallet, Qiwi от 10 рублей. ЮMoney: от 100 рублей. SteamPay: от 50 рублей. PerfectMoney: от $1.";
    }
}