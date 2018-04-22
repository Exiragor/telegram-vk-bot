<?php

namespace App\Services\Telegram\Commands;

use App\Models\User;
use App\Services\Telegram\TelegramBot;
use App\Services\Vk\VkBot;
use Illuminate\Support\Facades\Log;

class ReportCommand extends TelegramCommand {

    protected $signature = "report";

    // get report
    protected function handle()
    {
        if (!isset($this->params['chat_id'])) return false;
        $user = User::where('tg_chat_id', $this->params['chat_id'])->first();

        $vk = new VkBot();
        $vk->useToken($user->vk_token);
        $adsAccs = $vk->getAdsAccounts();
        Log::info($adsAccs);

        $response = '';
        $all_cost = 0;
        $all_impressions = 0;
        $all_clicks = 0;

        foreach ($adsAccs as $account) {
            $id = $account['account_id'];
            $campaigns = [];

            $res = $vk->getAdsCampaigns($id);
            Log::info($res);
            foreach ($res as $item) {
                $campaigns[] = $item['id'];
            }

            $campaigns_str = implode(',', $campaigns);

            $res = $vk->getAdsStatistic($id, $campaigns_str);

            foreach ($res as $campaign) {
                if (!empty($campaign['stats'])) {
                    $spent = 0;
                    $impressions = 0;
                    $clicks = 0;
                    foreach ($campaign['stats'] as $stats) {
                        $spent += (int) $stats['spent'];
                        $impressions += $stats['impressions'];
                        $clicks += $stats['clicks'];
                    }

                    $response .= "Расход за месяц: $spent рублей \n";
                    $all_cost += (int) $spent;

                    $response .= "Показов за месяц: $impressions\n";
                    $all_impressions += $impressions;

                    $response .= "Кликов за месяц: $clicks \n";
                    $all_clicks += $clicks;

                    if ($spent > 0)
                        $cpc = $spent / $clicks;
                    else
                        $cpc = 0;
                    $response .= "Средний CPC за месяц: $cpc рублей \n\n";
                } else {
                    $response .= "Расход за месяц: 0 рублей \n";
                    $response .= "Показов за месяц: 0\n";
                    $response .= "Кликов за месяц: 0 \n";
                    $response .= "Средний CPC за месяц: 0 рублей \n\n";
                }
            }
        }

        $response .= "Общий расход за месяц: $all_cost рублей \n";
        $response .= "Обших показов за месяц: $all_impressions\n";
        $response .= "Общих кликов за месяц: $all_clicks \n";
        if ($all_cost > 0)
            $all_cpc = $all_cost / $all_clicks;
        else $all_cpc = 0;
        $response .= "Общий средний CPC за месяц: $all_cpc рублей \n\n";

        $this->telegram->sendMessage($user->tg_chat_id, $response);
    }
}