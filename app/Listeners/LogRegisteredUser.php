<?php

namespace App\Listeners;

use App\Models\Log;
use App\Events\Registered;

class LogRegisteredUser
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
     * @param  Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $log = new Log();
        $log->data = json_encode($event->user);
        $log->message = $event->user->email. ' registered in the system';
        $log->type = 'App\Events\Registered';
        $log->ip_address = request()->ip();
        $log->user_agent = request()->header('User-Agent');
        $log->save();
    }
}
