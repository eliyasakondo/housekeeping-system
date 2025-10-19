<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use App\Models\Property;
use App\Models\Checklist;
use App\Policies\PropertyPolicy;
use App\Policies\ChecklistPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Gate::policy(Property::class, PropertyPolicy::class);
        Gate::policy(Checklist::class, ChecklistPolicy::class);
    }
}

