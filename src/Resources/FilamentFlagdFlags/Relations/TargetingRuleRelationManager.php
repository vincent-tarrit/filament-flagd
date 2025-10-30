<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Relations;


use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Vincenttarrit\FilamentFlagd\Models\FilamentFlagdEvaluator;

class TargetingRuleRelationManager extends RelationManager
{
    protected static string $relationship = 'targetingRule';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Toggle::make('result_variant'),

            Repeater::make('conditions')
                ->relationship('conditions')
                ->label('Conditions (OR group)')
                ->columnSpanFull()
                ->schema([
                    Select::make('type')
                        ->options([
                            'ref' => '$ref',
                            'in' => 'in',
                            'ends_with' => 'ends_with',
                            'starts_with' => 'starts_with',
                            'fractional' => 'fractional',
                        ])
                        ->reactive()
                        ->required(),

                    Select::make('ref')
                        ->visible(fn($get) => $get('type') === 'ref')
                        ->options(function() {
                                return  FilamentFlagdEvaluator::pluck('key', 'id')->toArray();
                        }),

                    Select::make('attribute')
                        ->visible(fn($get) => in_array($get('type'), ['in', 'ends_with', 'starts_with', 'fractional']))
                        ->options(function() {
                            return collect(config('filament-flagd.variables', []))->mapWithKeys(fn($item) => [$item => $item])->toArray();
                        }),

                    TagsInput::make('values')
                        ->visible(fn($get) => $get('type') === 'in')
                        ->columnSpanFull()
                        ->placeholder('List of values'),

                    TextInput::make('value')
                        ->visible(fn($get) => in_array($get('type'), ['ends_with', 'starts_with']))
                        ->columnSpanFull()
                        ->placeholder('@example.com'),

                    Slider::make('percent')
                        ->label('Percentage')
                        ->visible(fn($get) => $get('type') === 'fractional')
                        ->step(1)
                        ->range(minValue: 0, maxValue: 100)
                        ->default(0)
                        ->tooltips()
                        ->pips()
                        ->columnSpanFull()
                        ->fillTrack(),
                ])
                ->columns(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Rule ID'),
                TextColumn::make('conditions_count')
                    ->counts('conditions')
                    ->label('Conditions'),

                // Collapsible column for showing detailed conditions
               ViewColumn::make('conditions_detail')
                    ->label('Condition Details')
                    ->view('filament-flagd::filament-tables.conditions-collapsible', function($record) {
                        return [
                            'conditions' => $record->conditions,
                        ];
                    }),

                IconColumn::make('result_variant')
                ->boolean(),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make()
            ])
            ->recordActions([
                EditAction::make()
            ])
            ->bulkActions([]);
    }
}
