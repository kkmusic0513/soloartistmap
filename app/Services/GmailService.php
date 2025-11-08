<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class GmailService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect'));
        $this->client->addScope(Gmail::GMAIL_SEND);
        $this->client->setAccessType('offline');
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * メール送信
     */
    public function sendMail($to, $subject, $body)
    {
        $gmail = new Gmail($this->client);

        $rawMessage = "To: {$to}\r\n";
        $rawMessage .= "Subject: {$subject}\r\n";
        $rawMessage .= "Content-Type: text/plain; charset=utf-8\r\n\r\n";
        $rawMessage .= $body;

        $encodedMessage = rtrim(strtr(base64_encode($rawMessage), '+/', '-_'), '=');

        $message = new Message();
        $message->setRaw($encodedMessage);

        return $gmail->users_messages->send('me', $message);
    }
}
