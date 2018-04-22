<?php

namespace App\Services\Telegram;

use App\Services\Bot;
use Illuminate\Support\Facades\Log;

class TelegramBot extends Bot {

    public function __construct()
    {
        $this->host = 'https://api.telegram.org/bot'.self::getAccessToken() . '/';
    }

    public static function getAccessToken()
    {
        return config('telegram.token');
    }

    public function setWebHook(string $ownHost)
    {
        $url = $ownHost . '/api/telegram/hook/' . self::getAccessToken() . '/';
        Log::info($url);
        $method = 'setWebhook?url=' . $url;

        $result = $this->send($method, [], "GET");
        return $result;
    }

    public function getUpdates()
    {
        $method = 'getUpdates';
        $result = $this->send($method, []);
        return $result;
    }

    public function sendMessage(int $chat_id, string $message)
    {
        $method = 'sendMessage';
        $params = [
            'chat_id' => $chat_id,
            'text' => $message,
        ];

        $result = $this->send($method, $params);
        return $result;
    }
}