<?php

namespace App\Events;

class PreResetUserPasswordEvent
{
    public $credentials;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }
}
