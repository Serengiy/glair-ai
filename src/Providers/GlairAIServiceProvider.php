<?php

namespace Serengiy\GlairAI\Providers;

use Illuminate\Support\ServiceProvider;

class GlairAIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/glair-ai.php' => config_path('glair-ai.php'),
        ]);
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }
}
