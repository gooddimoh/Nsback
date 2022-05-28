<?php
return [
    'domain.protocol' => '', // http or https
    'domain.value' => '', // domain, e.g. keystore.loc

    'telegram.token' => "", // Telegram Bot API Token
    'telegram.refundChat.id' => 0, // Telegram Chat ID for notifications about a refund to the external payment method
    'telegram.ceoChat.id' => 0, // Telegram Chat ID of chief manager for important events
    'telegram.developerChat.id' => 0, //Telegram Chat ID of developer for bug reports

    'unisender.apiKey' => '',
    'unisender.sender.name' => '', // Displayed in the line "sender" of email
    'unisender.sender.email' => '', // Email "from". Must be verified
    'unisender.listId' => '', // List ID, required for send email

    'djekxa.apiKey' => '', // Supplier API Key

    'content.telegram.channel' => 'https://t.me/channel', // Telegram channel displayed for customers
    'content.telegram.support' => 'https://t.me/login', // Telegram support contact displayed for customers

];
