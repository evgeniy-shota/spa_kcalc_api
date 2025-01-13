<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

use App\Events\User\CreatedEvent;
use App\Listeners\User\CreateProfileListener;
use Illuminate\Http\Resources\Json\JsonResource;

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
        Event::listen(
            CreatedEvent::class,
            CreateProfileListener::class,
        );

        // JsonResource::withoutWrapping();
    }
}
