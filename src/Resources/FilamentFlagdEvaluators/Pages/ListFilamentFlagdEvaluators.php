<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdEvaluators\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdEvaluators\FilamentFlagdEvaluatorResource;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\FilamentFlagdFlagResource;

class ListFilamentFlagdEvaluators extends ListRecords
{
    protected static string $resource = FilamentFlagdEvaluatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
