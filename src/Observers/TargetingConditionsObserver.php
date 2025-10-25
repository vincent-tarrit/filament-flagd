<?php

namespace Vincenttarrit\FilamentFlagd\Observers;

use Vincenttarrit\FilamentFlagd\Models\FilamentFlagdTargetingCondition;
use Vincenttarrit\FilamentFlagd\Services\FlagdService;

class TargetingConditionsObserver
{
    public function created(FilamentFlagdTargetingCondition $condition)
    {
        $this->exportFlags();
    }

    public function updated(FilamentFlagdTargetingCondition $condition)
    {
        $this->exportFlags();
    }

    public function deleted(FilamentFlagdTargetingCondition $condition)
    {
        $this->exportFlags();
    }

    protected function exportFlags()
    {
        $content = app(FlagdService::class)->json();

        // Save to disk
        file_put_contents(config('filament-flagd.path'), $content);
    }
}
