<?php

namespace App\Providers;

use App\Models\Order;
use App\Policies\OrderPolicy;
use App\View\Composers\CartComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Order::class => OrderPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        URL::forceScheme('https');
        Paginator::useBootstrapFive();

        View::composer('layouts.app', CartComposer::class);
    }

   
}
