<?php

namespace App\Providers;

use App\Services\LinkService;
use Illuminate\Support\ServiceProvider;

class LinkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LinkService::class, function (\Illuminate\Contracts\Foundation\Application $app) {
            $options = [];
            if (config('app.linkService.secretKeyLength')) {
                $options['secretKeyLength'] = config('app.linkService.secretKeyLength');
            }
            return new LinkService($options);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
