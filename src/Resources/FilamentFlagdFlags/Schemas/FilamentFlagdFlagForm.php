<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FilamentFlagdFlagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required(),
                TextInput::make('state')
                    ->required()
                    ->default('ENABLED'),
                TextInput::make('default_variant'),
            ]);
    }
}
