<?php

namespace Rappasoft\LaravelLivewireTables;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use Livewire\ComponentHookRegistry;
use Rappasoft\LaravelLivewireTables\Commands\MakeCommand;
use Rappasoft\LaravelLivewireTables\Features\AutoInjectRappasoftAssets;
use Rappasoft\LaravelLivewireTables\Mechanisms\RappasoftFrontendAssets;

class LaravelLivewireTablesServiceProvider extends ServiceProvider
{
    public function boot()
    {

        AboutCommand::add('Rappasoft Laravel Livewire Tables', fn () => ['Version' => '3.0.0']);

        $this->mergeConfigFrom(
            __DIR__.'/../config/livewire-tables.php', 'livewire-tables'
        );

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'livewire-tables');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'livewire-tables');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/lang' => $this->app->langPath('livewire-tables'),
            ]);

            $this->publishes([
                __DIR__.'/../config/livewire-tables.php' => config_path('livewire-tables.php'),
            ], 'livewire-tables-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/rappasoft/livewire-tables'),
            ], 'livewire-tables-views');

            $this->commands([
                MakeCommand::class,
            ]);
        }

        (new RappasoftFrontendAssets)->boot();
        app('livewire')->componentHook(AutoInjectRappasoftAssets::class);
        ComponentHookRegistry::boot();

    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/livewire-tables.php', 'livewire-tables'
        );

        (new RappasoftFrontendAssets)->register();
    }
}
