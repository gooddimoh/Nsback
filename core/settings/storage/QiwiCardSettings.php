<?php

namespace core\settings\storage;

use core\payment\qiwiInvoice\QiwiP2P;

class QiwiCardSettings extends QiwiInvoiceSettings
{

    public function getName()
    {
        return "Картой";
    }

    public function getDescription()
    {
        return "Оплата при помощи банковской карты";
    }

    public function getIconPath()
    {
        return "/img/icons/payments/card.png";
    }

    public function getPaySource()
    {
        return [QiwiP2P::PAY_SOURCE_FILTER_CARD];
    }

}