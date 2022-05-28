<?php

namespace core\settings\storage;

use core\settings\Settings;

class SettingsRepository
{
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function set($section, $key, $value, $type = null)
    {
        return $this->settings->set($section, $key, $value);
    }

    public function get($section, $key)
    {
        return $this->settings->get($section, $key);
    }

}