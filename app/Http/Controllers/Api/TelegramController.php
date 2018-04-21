<?php

namespace App\Http\Controllers\Api;

use App\Services\Telegram\TelegramBot;
use App\Services\Telegram\TelegramCommands;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function hookInfo(Request $request)
    {
        Log::info($request);
        Log::info($request['message']['chat']['id']);

        if (
            isset($request['message']['entities']['0']['type'])
            &&
            $request['message']['entities']['0']['type'] == 'bot_command'
        ) {
            $tgCommands = new TelegramCommands();
            $command = $tgCommands->searchCommand(trim($request['message']['text']));

            if ($command) {
                $command->setParams([
                    'chat_id' => $request['message']['chat']['id'],
                    'name' => $request['message']['chat']['first_name'],
                ]);
                $command->execute();
            }
        }
    }
}
