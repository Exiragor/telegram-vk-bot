<?php

namespace App\Services\Vk;

use App\Services\Bot;
use Illuminate\Support\Facades\Log;

class VkBot extends Bot {

    protected $host = "";

    public static function getLinkForAccess()
    {
        return "https://oauth.vk.com/authorize?client_id=6041065&display=page"
        . "&redirect_uri=https://c9783589.ngrok.io/api/vk/authback"
        . "&scope=ads,offline&response_type=code&v=5.74";
    }
    public function getAccessToken(string $code)
    {
        $url = "https://oauth.vk.com/access_token"
        . "?client_id=6041065&client_secret=NwURCSWq78hjsrPbFxll"
        . "&redirect_uri=https://c9783589.ngrok.io/api/vk/authback&code=$code";

        $res = $this->sendToUri($url, [], "GET");
        Log::info($res);
        $arrRes = json_decode($res, true);

        return $arrRes['access_token'];
    }
}