<?php

namespace App\Listeners;

use App\Models\Log;
use App\Events\Failed;

class LogFailedLogin
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
     * @param  App\Events\Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        $log = new Log();
        $log->data = json_encode($event->request);
        $log->message = $event->request->email. ' failed authentication';
        $log->type = 'App\Events\Failed';
        $log->ip_address = $event->request->ip();
        $log->user_agent = $event->request->header('User-Agent');
        $log->save();
    }
}
