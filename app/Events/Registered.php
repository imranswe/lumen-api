<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Http\Request;

class Registered extends Event
{
	public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
