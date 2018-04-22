<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Commands\ActivateCommand;
use App\Services\Telegram\Commands\ReportCommand;
use Illuminate\Support\Facades\Log;

class TelegramCommands {
    protected $listCommands = [
        ActivateCommand::class,
        ReportCommand::class,
    ];

    public function searchCommand(string $commandName)
    {
        Log::info($commandName);
        foreach($this->listCommands as $command) {
            $c = new $command();

            if ($c->compare($commandName)) {
                return $c;
            }
        }
    }
}