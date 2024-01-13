<?php

namespace Nerbiz\CrawlShield;

use Illuminate\Support\ServiceProvider;

class CrawlShieldServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/crawl-shield.php', 'crawl-shield');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([__DIR__ . '/../config/crawl-shield.php' => config_path('crawl-shield.php')]);
    }
}
