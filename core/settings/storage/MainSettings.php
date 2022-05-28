<?php

namespace core\settings\storage;

use core\settings\SettingsStorage;

class MainSettings
{

    private $headCode;
    private $endBodyCode;
    private $disableSite;
    private $disableSiteMessage;
    private $disableProductUpdate;

    private $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
        $this->headCode = $this->get('headCode');
        $this->endBodyCode = $this->get('endBodyCode');
        $this->disableSite = $this->get('disableSite');
        $this->disableSiteMessage = $this->get('disableSiteMessage');
        $this->disableProductUpdate = $this->get('disableProductUpdate');
    }

    /**
     * @return mixed|null
     */
    public function getHeadCode()
    {
        return $this->headCode;
    }

    /**
     * @return mixed|null
     */
    public function getEndBodyCode()
    {
        return $this->endBodyCode;
    }

    public function isDisableSite()
    {
        return (bool) $this->disableSite;
    }

    public function getDisableSiteMessage()
    {
        return $this->disableSiteMessage;
    }

    public function isDisableProductUpdate()
    {
        return (bool) $this->disableProductUpdate;
    }

    private function get($key)
    {
        return $this->settingsRepository->get(SettingsStorage::GROUP_MAIN, $key);
    }

}