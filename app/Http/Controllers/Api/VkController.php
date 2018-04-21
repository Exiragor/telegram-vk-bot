<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\Vk\VkBot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VkController extends Controller
{
    public function authBack(Request $request)
    {
        if (isset($request['code'])) {
            $vk = new VkBot();
            $token = $vk->getAccessToken($request['code']);

            $user = User::where('tg_chat_id', session('id'))->get();
            $user->vk_token = $token;
            $user->save();
        }

        return response("Your account was activated");
    }

    public function auth(Request $request)
    {
        session('id', $request['id']);

        return redirect(VkBot::getLinkForAccess());
    }
}
