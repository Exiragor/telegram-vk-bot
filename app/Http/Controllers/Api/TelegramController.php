<?php

namespace App\Http\Controllers\Api;

use App\Services\Telegram\TelegramBot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function hookInfo(Request $request)
    {
        Log::info($request);
        Log::info($request['message']['chat']['id']);

        if (isset($request['message']['chat']['id'])) {
            $telegram = new TelegramBot();
            $telegram->sendMessage($request['message']['chat']['id'], "Hello23");
        }
    }
}
