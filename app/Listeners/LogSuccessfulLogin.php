<?php

namespace App\Listeners;

use App\Models\Log;
use App\Events\LoginSuccess;

class LogSuccessfulLogin
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
     * @param  Illuminate\Auth\Events\LoginSuccess  $event
     * @return void
     */
    public function handle(LoginSuccess $event)
    {
        $log = new Log();
        $log->data = json_encode($event->user);
        $log->message = $event->user->email. ' Loged in the sucessfully';
        $log->type = 'App\Events\LoginSuccess';
        $log->ip_address = request()->ip();
        $log->user_agent = request()->header('User-Agent');
        $log->save();
    }
}
