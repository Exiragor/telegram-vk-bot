<?php

namespace App\Services\Telegram\Commands;

use App\Services\Telegram\TelegramBot;

class TelegramCommand {
    protected $signature;
    protected $params;
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new TelegramBot();
    }

    protected function handle()
    {
    }

    public function compare($commandName)
    {
        if ($commandName == '/' .  $this->signature) {
            return true;
        } else {
            return false;
        }
    }

    public function execute()
    {
        $this->handle();
    }

    public function setParams(array $params= [])
    {
        $this->params = $params;
    }
}