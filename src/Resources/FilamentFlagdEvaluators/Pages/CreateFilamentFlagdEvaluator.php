<?php

namespace Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdEvaluators\Pages;

use Filament\Resources\Pages\CreateRecord;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdEvaluators\FilamentFlagdEvaluatorResource;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\FilamentFlagdFlagResource;

class CreateFilamentFlagdEvaluator extends CreateRecord
{
    protected static string $resource = FilamentFlagdEvaluatorResource::class;
}
