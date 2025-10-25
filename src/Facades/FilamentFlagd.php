<?php

namespace Vincenttarrit\FilamentFlagd\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Vincenttarrit\FilamentFlagd\FilamentFlagd
 */
class FilamentFlagd extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Vincenttarrit\FilamentFlagd\FilamentFlagd::class;
    }
}
