<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\Telegram\TelegramBot;
use App\Services\Vk\VkBot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class VkController extends Controller
{
    public function authBack(Request $request)
    {
        if (isset($request['code'])) {
            $vk = new VkBot();
            $token = $vk->getAccessToken($request['code']);

            $users = User::where('id', Cookie::get('user_id'))->get();
            foreach ($users as $user) {
                $user->vk_token = $token;
                $user->save();

                $telegram = new TelegramBot();
                $telegram->sendMessage($user->tg_chat_id, 'Your account was activated!');
            }
        }
        return response("Your account was activated");
    }

    public function auth(Request $request)
    {
        $cookie = cookie('user_id', $request['id'], 15);
        return redirect(VkBot::getLinkForAccess())->cookie($cookie);
    }
}
