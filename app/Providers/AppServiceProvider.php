<?php

namespace App\Providers;

use App\Database\Connectors\NeonPostgresConnector;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('db.connector.pgsql', fn () => new NeonPostgresConnector());
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}

