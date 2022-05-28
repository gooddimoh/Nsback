<?php

namespace core\settings\storage;

use core\payment\qiwiInvoice\QiwiP2P;
use core\settings\SettingsStorage;

class QiwiInvoiceSettings implements PaymentSystemInterface, DepositInterface
{
    public $publicKey;
    public $secretKey;

    protected $description;
    protected $disabled;

    protected $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;

        $this->publicKey = $this->get('publicKey');
        $this->secretKey = $this->get('secretKey');

        $this->disabled = $this->get('disabled');
        $this->description = $this->get('description');
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function getName()
    {
        return "Qiwi";
    }

    public function getIconPath()
    {
        return "/img/icons/payments/qiwi.png";
    }

    /**
     * @return mixed|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed|null
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    public function getPaySource()
    {
        return [QiwiP2P::PAY_SOURCE_FILTER_CARD, QiwiP2P::PAY_SOURCE_FILTER_QIWI];
    }

    protected function set($key, $value, $type = null)
    {
        return $this->settingsRepository->set(SettingsStorage::GROUP_QIWI_INVOICE, $key, $value, $type);
    }

    protected function get($key)
    {
        return $this->settingsRepository->get(SettingsStorage::GROUP_QIWI_INVOICE, $key);
    }

    public function getWarning()
    {
        return null;
    }

    public function getMinimum()
    {
        return 5;
    }

    public function getMaximum()
    {
        return 10000;
    }
}