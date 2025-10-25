<?php

namespace Vincenttarrit\FilamentFlagd;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Vincenttarrit\FilamentFlagd\Commands\FilamentFlagdCommand;
use Vincenttarrit\FilamentFlagd\Testing\TestsFilamentFlagd;

class FilamentFlagdServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-flagd';

    public static string $viewNamespace = 'filament-flagd';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('vincent-tarrit/filament-flagd');
            });

        $configFileName = 'filament-flagd';

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-flagd/{$file->getFilename()}"),
                ], 'filament-flagd-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsFilamentFlagd);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'vincent-tarrit/filament-flagd';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-flagd', __DIR__ . '/../resources/dist/components/filament-flagd.js'),
            Css::make('filament-flagd-styles', __DIR__ . '/../resources/dist/filament-flagd.css'),
            Js::make('filament-flagd-scripts', __DIR__ . '/../resources/dist/filament-flagd.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            FilamentFlagdCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
       return collect(app(Filesystem::class)->files(__DIR__ . '/../database/migrations'))->map(function($file) {
           return str($file->getBasename())->before('.')->value();
       })
           ->toArray();
    }
}
