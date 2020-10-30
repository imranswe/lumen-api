<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Registered' => [
            'App\Listeners\LogRegisteredUser',
        ],

        'App\Events\AttemptingLogin' => [
            'App\Listeners\LogAuthenticationAttempt',
        ],

        'App\Events\Authenticated' => [
            'App\Listeners\LogAuthenticated',
        ],

        'App\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],

        'App\Events\Failed' => [
            'App\Listeners\LogFailedLogin',
        ],
    ];
}
