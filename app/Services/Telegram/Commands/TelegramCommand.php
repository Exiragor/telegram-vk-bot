<?php

namespace App\Services\Telegram\Commands;

class TelegramCommand {
    protected $signature;

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
}