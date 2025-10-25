<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\FilamentFlagdFlagResource;

class ListFilamentFlagdFlags extends ListRecords
{
    protected static string $resource = FilamentFlagdFlagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
