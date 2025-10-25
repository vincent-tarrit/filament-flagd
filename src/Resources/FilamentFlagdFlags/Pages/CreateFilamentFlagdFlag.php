<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Pages;

use Filament\Resources\Pages\CreateRecord;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\FilamentFlagdFlagResource;

class CreateFilamentFlagdFlag extends CreateRecord
{
    protected static string $resource = FilamentFlagdFlagResource::class;
}
