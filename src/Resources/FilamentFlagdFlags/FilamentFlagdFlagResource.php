<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Vincenttarrit\FilamentFlagd\Models\FilamentFlagdFlag;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Pages\CreateFilamentFlagdFlag;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Pages\EditFilamentFlagdFlag;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Pages\ListFilamentFlagdFlags;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Relations\TargetingRuleRelationManager;

class FilamentFlagdFlagResource extends Resource
{
    protected static ?string $model = FilamentFlagdFlag::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('key')->required(),
            Select::make('state')->options([
                'ENABLED' => 'ENABLED',
                'DISABLED' => 'DISABLED',
            ])->default('ENABLED'),
            Toggle::make('default_variant')->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('key')->label('Flag Key'),
            TextColumn::make('state'),
            IconColumn::make('default_variant'),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            TargetingRuleRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFilamentFlagdFlags::route('/'),
            'create' => CreateFilamentFlagdFlag::route('/create'),
            'edit' => EditFilamentFlagdFlag::route('/{record}/edit'),
        ];
    }
}
