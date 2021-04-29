<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class MessageService
{
    private $baseUrl;
    private $token;
    private $client;

    function __construct()
    {
        $this->baseUrl = env('TELEGRAM_API_URL');
        $this->token = env('TELEGRAM_BOT_TOKEN');

        $this->client = new Client(
            ['base_uri' => $this->baseUrl . 'bot' . $this->token . '/']
        );
    }

    public function getMessages()
    {
        $response = $this->client->request('GET', 'getUpdates');

        if ($response->getStatusCode() === 200) {
            $messages = json_decode($response->getBody()->getContents(), true);

            foreach ($messages['result'] as $result) {
                if (isset($result['message']['text'])) {

                    $newId = $result['update_id'];
                    $text = $result['message']['text'];
                    $chatId = $result['message']['from']['id'];

                    $palindromService = new Palindrom();
                    $palindrom = $palindromService->palindrom($text);

                    $messageService = new MessageService();
                    $messageService->sendMessage($chatId, $palindrom);

                    $this->client->request('GET', 'getUpdates', [
                        'query' => [
                            'offset' => $newId + 1
                        ]
                    ]);
                }
            }
        }
    }

    public function sendMessage($chatId, $text)
    {
        $response = $this->client->request('GET', 'sendMessage', [
            'query' => [
                'chat_id' => $chatId,
                'text' => $text
            ]
        ]);
    }
}
