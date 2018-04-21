<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Telegram\TelegramBot;
use Illuminate\Support\Facades\Log;

class TgSetWebHook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tg:setwebhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set host and activate new webhook. For example: test.ru';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->tg = new TelegramBot();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $res = $this->tg->setWebHook(env("TELEGRAM_HOST"));
        Log::info($res);
        $this->info(json_decode($res, true)['description']);
        return true;
    }
}
