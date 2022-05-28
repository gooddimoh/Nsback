<?php

namespace core\settings\storage;

use core\settings\SettingsStorage;

class CoinbaseSettings implements PaymentSystemInterface, DepositInterface
{
    private $apiKey;
    private $webHookKey;
    private $description;
    private $disable;

    private $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
        $this->apiKey = $this->get('apiKey');
        $this->webHookKey = $this->get('webHookKey');
        $this->description = $this->get('description');
        $this->disable = $this->get('disable');
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getWebHookKey()
    {
        return $this->webHookKey;
    }

    public function getName()
    {
        return "Криптовалюты";
    }

    public function getIconPath()
    {
        return "/img/icons/payments/coinbase.png";
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
        return $this->settingsRepository->get(SettingsStorage::GROUP_COINBASE, $key);
    }

    public function getWarning()
    {
        return "Платежи: от 30 рублей.<br>Если платите через Binance - сети: BEP2, BEP20 <u>не</u> поддерживаются. "
            . "<a href='/site/coinbase-allowed-network' target='_blank'>(подробнее)</a>";
    }

    public function getMinimum()
    {
        return 35;
    }

    public function getMaximum()
    {
        return 35000;
    }
}