<?php

declare(strict_types=1);

namespace Ngmy\LaravelMysqlDumper;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Ngmy\LaravelMysqlDumper\Console\DumpCommand;

class MysqlDumperServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        $configPath = __DIR__ . '/../config/ngmy-mysql-dumper.php';
        $this->mergeConfigFrom($configPath, 'ngmy-mysql-dumper');
        $this->publishes([$configPath => \config_path('ngmy-mysql-dumper.php')], 'ngmy-mysql-dumper');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(DumpCommand::class, function (Application $app) {
            return new DumpCommand($app->make('config'));
        });

        $this->commands([
            DumpCommand::class,
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            DumpCommand::class,
        ];
    }
}
