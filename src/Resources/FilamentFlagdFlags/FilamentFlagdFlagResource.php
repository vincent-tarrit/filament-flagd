<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags;


use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Vincenttarrit\FilamentFlagd\Models\FilamentFlagdFlag;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Pages\CreateFilamentFlagdFlag;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Pages\EditFilamentFlagdFlag;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Pages\ListFilamentFlagdFlags;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Schemas\FilamentFlagdFlagForm;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Tables\FilamentFlagdFlagsTable;

class FilamentFlagdFlagResource extends Resource
{
    protected static ?string $model = FilamentFlagdFlag::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'key';

    public static function form(Schema $schema): Schema
    {
        return FilamentFlagdFlagForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FilamentFlagdFlagsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
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
