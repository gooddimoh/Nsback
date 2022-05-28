<?php

namespace core\lib\telegram;

use core\lib\telegram\template\MessageTemplate;
use yii\httpclient\Client;

/**
 * Узнать ID чата: https://qna.habr.com/q/243109
 */
class TelegramMessage
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function sendMessage($chatId, $message, $parseMode = "HTML")
    {
        return $this->query("sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => $parseMode,
        ]);
    }

    public function sendPhoto($chatId, $photo, $caption = null)
    {
        $this->query("sendPhoto", [
            'chat_id' => $chatId,
            'photo' => $photo,
            'caption' => $caption,
        ]);
    }

    public function sendMessageByTemplate(MessageTemplate $message, $chatId)
    {
       $this->sendMessage($chatId, $message->getMessage());
    }

    protected function query($action, array $params)
    {
        $url = "https://api.telegram.org/bot{$this->token}/$action";
        $client = new Client();

        return $client->createRequest()
            ->setMethod('POST')
            ->setUrl($url)
            ->setData($params)
            ->send();

    }


}