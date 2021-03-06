<?php

namespace App\Events;

use Illuminate\Http\Request;

class Failed extends Event
{
	public $request;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
