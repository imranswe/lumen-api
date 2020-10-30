<?php

namespace App\Listeners;

use App\Models\Log;
use App\Events\AttemptingLogin;

class LogAuthenticationAttempt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Illuminate\Auth\Events\Attempting  $event
     * @return void
     */
    public function handle(AttemptingLogin $event)
    {
        $log = new Log();
        $log->data = json_encode($event->request);
        $log->message = $event->request->email. ' attempted authentication';
        $log->type = 'App\Events\AttemptingLogin';
        $log->ip_address = $event->request->ip();
        $log->user_agent = $event->request->header('User-Agent');
        $log->save();
    }
}
