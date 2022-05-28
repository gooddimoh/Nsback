<?php

namespace core\lib\payment;

use core\entities\payment\Payment;
use core\settings\storage\BalanceSettings;
use core\settings\storage\DepositInterface;
use core\settings\storage\LavaSettings;
use core\settings\storage\PayeerSettings;
use core\settings\storage\PaymentSystemInterface;
use core\settings\storage\QiwiCardSettings;
use core\settings\storage\MazeBankSettings;
use core\settings\storage\EnotSettings;
use core\settings\storage\CoinbaseSettings;
use core\settings\storage\WebMoneySettings;
use core\settings\storage\FreekassaSettings;
use core\settings\storage\QiwiInvoiceSettings;
use yii\helpers\ArrayHelper;

class PaymentSystemList
{
    public $map = [
        Payment::METHOD_BALANCE => BalanceSettings::class,

        Payment::METHOD_QIWI_CARD => QiwiCardSettings::class,
        Payment::METHOD_QIWI_P2P => QiwiInvoiceSettings::class,
        Payment::METHOD_COINBASE => CoinbaseSettings::class,
        Payment::METHOD_PAYEER => PayeerSettings::class,
        Payment::METHOD_LAVA => LavaSettings::class,
        Payment::METHOD_FREEKASSA => FreekassaSettings::class,
        Payment::METHOD_ENOT => EnotSettings::class,

        // Test
        Payment::METHOD_MAZE_BANK => MazeBankSettings::class,
        // Inactive
        Payment::METHOD_WEB_MONEY => WebMoneySettings::class,


    ];

    public function getClassByKey($key)
    {
        return ArrayHelper::getValue($this->map, $key);
    }

    /**
     * @param $key
     * @return mixed|object|PaymentSystemInterface|DepositInterface
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function createInstance($key)
    {
        return \Yii::$container->get($this->getClassByKey($key));
    }

    public function getAll()
    {
        $result = [];

        foreach ($this->map as $key => $settingsClass) {
            $result[$key] = \Yii::$container->get($settingsClass);
        }

        return $result;
    }

}