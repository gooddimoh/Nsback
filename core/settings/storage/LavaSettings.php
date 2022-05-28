<?php

namespace core\settings\storage;

use core\settings\SettingsStorage;

class LavaSettings implements PaymentSystemInterface
{
    private $description;
    private $disable;

    private $jwtToken;
    private $walletTo;
    private SettingsRepository $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;

        $this->description = $this->get('description');
        $this->disable = $this->get('disable');

        $this->jwtToken = $this->get('jwtToken');
        $this->walletTo = $this->get('walletTo');
    }

    private function get($key)
    {
        return $this->settingsRepository->get(SettingsStorage::GROUP_LAVA, $key);
    }

    /**
     * @return mixed|null
     */
    public function getJwtToken()
    {
        return $this->jwtToken;
    }

    /**
     * @param mixed|null $jwtToken
     * @return LavaSettings
     */
    public function setJwtToken($jwtToken)
    {
        $this->jwtToken = $jwtToken;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getWalletTo()
    {
        return $this->walletTo;
    }

    /**
     * @param mixed|null $walletTo
     * @return LavaSettings
     */
    public function setWalletTo($walletTo)
    {
        $this->walletTo = $walletTo;
        return $this;
    }

    public function getName()
    {
        return "Lava";
    }

    public function getIconPath()
    {
        return "/img/icons/payments/lava.svg";
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