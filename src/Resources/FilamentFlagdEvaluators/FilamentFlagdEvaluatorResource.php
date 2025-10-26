<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdEvaluators;

use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
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
                                'in' => 'In',
                            ])
                            ->reactive()
                            ->required(),

                        TextInput::make('attribute')
                            ->visible(fn($get) => in_array($get('type'), ['in', 'ends_with', 'starts_with']))
                            ->placeholder('email'),

                        TagsInput::make('values')
                            ->visible(fn($get) => $get('type') === 'in')
                            ->columnSpanFull()
                            ->placeholder('List of values'),

                        TextInput::make('value')
                            ->visible(fn($get) => in_array($get('type'), ['ends_with', 'starts_with']))
                            ->columnSpanFull()
                            ->placeholder('@example.com'),
                    ])
                    ->addActionLabel('Add Condition')
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
