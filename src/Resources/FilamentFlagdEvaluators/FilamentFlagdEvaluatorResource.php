<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdEvaluators;

use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Vincenttarrit\FilamentFlagd\Models\FilamentFlagdEvaluator;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdEvaluators\Pages\CreateFilamentFlagdEvaluator;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdEvaluators\Pages\EditFilamentFlagdEvaluator;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdEvaluators\Pages\ListFilamentFlagdEvaluators;

class FilamentFlagdEvaluatorResource extends Resource
{
    protected static ?string $model = FilamentFlagdEvaluator::class;

    public static function getNavigationParentItem(): ?string
    {
        return config('filament-flagd.navigation.label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label('Reference Key')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('Used in JSON as $ref: "key"'),

                TextInput::make('description')
                    ->label('Description')
                    ->placeholder('e.g. All employees with @company.com emails'),

                Repeater::make('conditions')
                    ->label('Conditions')
                    ->relationship()
                    ->schema([
                        Select::make('type')
                            ->label('Condition Type')
                            ->options([
                                'ends_with' => 'Ends With',
                                'starts_with' => 'Starts With',
                                'equals' => 'Equals',
                                'in' => 'In',
                            ])
                            ->required(),

                        TextInput::make('attribute')
                            ->label('Attribute (e.g. email)')
                            ->required(),

                        TextInput::make('value')
                            ->label('Value (e.g. @company.com)')
                            ->required(),
                    ])
                    ->createItemButtonLabel('Add Condition')
                    ->orderable()
                    ->collapsed()
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')->label('Key')->searchable(),
                TextColumn::make('description')->limit(50),
                TextColumn::make('conditions_count')
                    ->counts('conditions')
                    ->label('Conditions'),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFilamentFlagdEvaluators::route('/'),
            'create' => CreateFilamentFlagdEvaluator::route('/create'),
            'edit' => EditFilamentFlagdEvaluator::route('/{record}/edit'),
        ];
    }
}
