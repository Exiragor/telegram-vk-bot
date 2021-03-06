<?php

namespace App\Services\Vk;

use App\Models\User;
use App\Services\Bot;
use Illuminate\Support\Facades\Log;

class VkBot extends Bot {

    protected $host = "https://api.vk.com/method/";
    protected $token = "";

    public static function getLinkForAccess()
    {
        $id = config('vk.app_id');
        return "https://oauth.vk.com/authorize?client_id=$id&display=page"
        . "&redirect_uri=".config('app.url')."/api/vk/authback"
        . "&scope=ads,offline&response_type=code&v=5.74";
    }

    // get token for vk
    public function getAccessToken(string $code)
    {
        $id = config('vk.app_id');
        $key = config('vk.app_key');
        $url = "https://oauth.vk.com/access_token"
        . "?client_id=$id&client_secret=$key"
        . "&redirect_uri=".config('app.url')."/api/vk/authback&code=$code";

        $res = $this->sendToUri($url, [], "GET");
        $arrRes = json_decode($res, true);

        return $arrRes['access_token'];
    }

    // get active accounts of user for ads
    public function getAdsAccounts()
    {
        $method = 'ads.getAccounts';
        $params = $this->getParams([]);

        $res = $this->send($method, $params);
        $res = json_decode($res, true);
        return $res['response'];
    }

    // get active ads campaigns
    public function getAdsCampaigns(int $account_id)
    {
        $method = 'ads.getCampaigns';
        $params = $this->getParams([
            'account_id' => $account_id
        ]);

        $campaigns = $this->send($method, $params);

        $res = json_decode($campaigns, true);
        return $res['response'];
    }

    // get a statistic about campaigns
    public function getAdsStatistic(int $account_id, string $campaigns)
    {
        $method = 'ads.getStatistics';
        $params = $this->getParams([
            'account_id' => $account_id,
            'ids_type' => 'campaign',
            'ids' => $campaigns,
            'period' => 'month',
            'date_from' => date("Y-m"),
            'date_to' => date("Y-m"),
        ]);

        $res = $this->send($method, $params);
        Log::info($res);
        $res = json_decode($res, true);
        return $res['response'];
    }

    private function getParams($newParams = [])
    {
        $standart = [
            'access_token' => $this->token,
            'v' => '5.74',
        ];

        return array_merge($standart, $newParams);
    }

    public function useToken($token)
    {
        $this->token = $token;
    }

}