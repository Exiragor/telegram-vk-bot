<?php

namespace App\Services\Telegram\Commands;

use App\Models\User;
use App\Services\Telegram\TelegramBot;
use App\Services\Vk\VkBot;
use Illuminate\Support\Facades\Log;

class ActivateCommand extends TelegramCommand {

    protected $signature = "activate";

    protected function handle()
    {
        if (isset($this->params['chat_id'])) {
            $chat_id = $this->params['chat_id'];

            $users = User::where('tg_chat_id', $chat_id)->get();

            if ($users->count() < 1) {
                $user = new User();
                $user->tg_chat_id = $chat_id;
                $user->name = $this->params['name'];
                $user->save();
            } else {
                $user = $users[0];
            }

            $id = $user->id;

            $link = config('socials.host') . '/api/vk/auth?id=' . $id;

            $this->telegram->sendMessage($this->params['chat_id'], $link);
        }
    }
}