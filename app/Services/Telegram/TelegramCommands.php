<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Commands\ActivateCommand;

class TelegramCommands {
    protected $listCommands = [
        ActivateCommand::class,
    ];

    public function searchCommand(string $commandName)
    {
        foreach($this->listCommands as $command) {
            $c = new $command();

            if ($c->compare($commandName)) {
                return $c;
            }
        }
    }
}