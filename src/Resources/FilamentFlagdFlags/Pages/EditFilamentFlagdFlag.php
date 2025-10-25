<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\FilamentFlagdFlagResource;

class EditFilamentFlagdFlag extends EditRecord
{
    protected static string $resource = FilamentFlagdFlagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
