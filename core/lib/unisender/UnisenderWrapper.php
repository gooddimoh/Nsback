<?php

namespace core\lib\unisender;

use core\lib\unisender\logger\LoggerMail;
use Unisender\ApiWrapper\UnisenderApi;

class UnisenderWrapper
{
    private UnisenderApi $api;
    private $senderName;
    private $senderEmail;
    private $listId;
    private $logger;

    public function __construct(UnisenderApi $api, LoggerMail $logger, $senderName, $senderEmail, $listId)
    {
        $this->api = $api;
        $this->senderName = $senderName;
        $this->senderEmail = $senderEmail;
        $this->listId = $listId;
        $this->logger = $logger;
    }

    public function sendEmail($email, $subject, $body)
    {
        try {
            $response = $this->api->sendEmail([
                'email' => $email,
                'sender_name' => $this->senderName,
                'sender_email' => $this->senderEmail,
                'subject' => $subject,
                'body' => $body,
                'list_id' => $this->listId,
            ]);
            $result = json_decode($response, true);

            if (isset($result['result']['email_id'])) {
                $this->logger->success($result['result']['email_id'], $email);
                return true;
            } else {
                $this->logger->fail($response);
            }
        } catch (\Exception $exception) {
            $this->logger->fail($exception->getMessage());
        }

        return false;
    }

}