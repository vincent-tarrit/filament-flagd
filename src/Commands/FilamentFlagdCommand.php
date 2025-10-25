<?php

namespace Vincenttarrit\FilamentFlagd\Commands;

use Illuminate\Console\Command;

class FilamentFlagdCommand extends Command
{
    public $signature = 'filament-flagd';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
