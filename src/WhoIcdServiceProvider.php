<?php

declare(strict_types=1);

namespace WhoIcd;

use Illuminate\Support\ServiceProvider;

class WhoIcdServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/who-icd.php', 'who-icd');

        $this->app->singleton(WhoIcdConnector::class, function ($app) {
            $config = $app['config']['who-icd'];

            return new WhoIcdConnector(
                clientId: $config['client_id'],
                clientSecret: $config['client_secret'],
                apiVersion: $config['api_version'] ?? 'v2',
                language: $config['language'] ?? 'en',
                tokenEndpoint: $config['token_endpoint'] ?? 'https://icdaccessmanagement.who.int/connect/token',
                baseUrl: $config['base_url'] ?? 'https://id.who.int',
            );
        });

        $this->app->alias(WhoIcdConnector::class, 'who-icd');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/who-icd.php' => config_path('who-icd.php'),
            ], 'who-icd-config');
        }
    }
}
