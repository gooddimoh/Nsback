<?php

namespace core\services\order;

use core\entities\order\OrderHistory;
use core\lib\unisender\RenderMail;
use core\lib\unisender\UnisenderWrapper;
use core\repositories\order\OrderHistoryRepository;
use frontend\forms\Order\OrderOwnForm;

class OrderHistoryService
{
    private $history;
    private $unisenderWrapper;

    public function __construct(OrderHistoryRepository $history, UnisenderWrapper $unisenderWrapper)
    {
        $this->history = $history;
        $this->unisenderWrapper = $unisenderWrapper;
    }

    public function create(OrderOwnForm $form)
    {
        $history = OrderHistory::make($form->email);
        $this->history->save($history);

        $this->unisenderWrapper->sendEmail($history->email, "Мои покупки", RenderMail::render("order/history-html", ['history' => $history]));
    }

}