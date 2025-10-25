<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\Relations;


use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class TargetingRuleRelationManager extends RelationManager
{
    protected static string $relationship = 'targetingRule';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Repeater::make('conditions')
                ->relationship('conditions')
                ->label('Conditions (OR group)')
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

                    TextInput::make('ref')
                        ->visible(fn($get) => $get('type') === 'ref')
                        ->placeholder('group1'),

                    TextInput::make('attribute')
                        ->visible(fn($get) => in_array($get('type'), ['in', 'ends_with', 'starts_with', 'equals', 'fractional']))
                        ->placeholder('email'),

                    TagsInput::make('values')
                        ->visible(fn($get) => $get('type') === 'in')
                        ->placeholder('List of values'),

                    TextInput::make('value')
                        ->visible(fn($get) => in_array($get('type'), ['ends_with', 'starts_with', 'equals']))
                        ->placeholder('@example.com'),

                    TextInput::make('percent')
                        ->visible(fn($get) => $get('type') === 'fractional')
                        ->numeric(),
                ])
                ->columns(2),

            Toggle::make('result_variant')
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
