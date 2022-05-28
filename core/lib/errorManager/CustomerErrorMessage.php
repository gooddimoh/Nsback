<?php

namespace core\lib\errorManager;

class CustomerErrorMessage
{
    const DEFAULT_ERROR = [
        'userMessage' => "Произошла ошибка при выдаче товара. Мы уже работаем над устранением проблемы, с Вашим заказом всё в порядке. Вы можете <b>подождать, либо отменить заказ</b>.",
        'supportMessage' => "Системная ошибка",
    ];

    private $userMessage;
    private $supportMessage;

    private $map = [
        'has not available accounts' => [
            'userMessage' => "Система проверки качества обнаружила проблему с приобретенным товаром, и изъяла его из продажи. Другой товар по данной позиции закончился, и мы не можем выдать замену прямо сейчас.\n\nПожалуйста, подождите пока мы добавим новые позиции, либо обратитесь в поддержку для отмены заказа и возврата средств. Приносим извинения за неудобства",
            'supportMessage' => "Изъятие \"Системы Контроля Качества\"",
        ],
    ];

    public function __construct($errorMessage)
    {
        $response = $this->map[$errorMessage] ?? self::DEFAULT_ERROR;
        $this->userMessage = $response['userMessage'];
        $this->supportMessage = $response['supportMessage'];
    }

    /**
     * @return string
     */
    public function getUserMessage(): string
    {
        return $this->userMessage;
    }

    /**
     * @return string
     */
    public function getSupportMessage(): string
    {
        return $this->supportMessage;
    }

}