<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdEvaluators\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Vincenttarrit\FilamentFlagd\Models\FilamentFlagdEvaluator;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdEvaluators\FilamentFlagdEvaluatorResource;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\FilamentFlagdFlagResource;

class EditFilamentFlagdEvaluator extends EditRecord
{
    protected static string $resource = FilamentFlagdEvaluatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
