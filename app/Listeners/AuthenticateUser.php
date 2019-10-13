<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Session;
use Auth;
class AuthenticateUser
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
     * @param  Auhtenticated  $event
     * @return void
     */
    public function handle(Login $event)
    {
        Session::put('is_admin', Auth::user()->isAdministrator());
    }
}
