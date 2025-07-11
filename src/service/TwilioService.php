<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService {
    private string $sid;
    private string $token;
    private string $from;

    public function __construct() {
        $this->sid = $_ENV['TWILIO_SID'];
        $this->token = $_ENV['TWILIO_TOKEN'];
        $this->from = $_ENV['TWILIO_FROM']; // numéro Twilio
    }

    public function sendSMS(string $to, string $message): bool|string {
        try {
            $client = new Client($this->sid, $this->token);
            $client->messages->create($to, [
                'from' => $this->from,
                'body' => $message
            ]);
            return true;
        } catch (\Exception $e) {
            return $e->getMessage(); // pour log ou debug
        }
    }
}
