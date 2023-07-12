<?php

namespace App\Providers;

use Aws\Textract\TextractClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TextractClient::class, function() {
            return new TextractClient([
                'version' => config('aws.version'),
                'region' => config('aws.region'),
                'credentials' => [
                    'key' => config('aws.credentials.key'),
                    'secret' => config('aws.credentials.secret'),
                ],
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
