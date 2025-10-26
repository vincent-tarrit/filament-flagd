<?php

namespace Vincenttarrit\FilamentFlagd;

use BezhanSalleh\PluginEssentials\Concerns\Plugin as PluginEssentials;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdEvaluators\FilamentFlagdEvaluatorResource;
use Vincenttarrit\FilamentFlagd\Resources\FilamentFlagdFlags\FilamentFlagdFlagResource;

class FilamentFlagdPlugin implements Plugin
{
    use PluginEssentials\HasGlobalSearch;
    use PluginEssentials\HasLabels;
    use PluginEssentials\HasNavigation;
    use PluginEssentials\WithMultipleResourceSupport; // For multi-forResource plugins

    public function getId(): string
    {
        return 'filament-flagd';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                FilamentFlagdFlagResource::class,
                FilamentFlagdEvaluatorResource::class
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
