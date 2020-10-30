<?php

namespace App\Events;

use App\Models\User;

class LoginSuccess extends Event
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
