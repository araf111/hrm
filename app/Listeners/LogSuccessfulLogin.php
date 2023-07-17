<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
//use Illuminate\Http\Request;

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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        DB::table('login_activities')->insert(array(
            'user_id'=>authInfo()->id,
            'ip_address'=>\Request::ip(),
            'user_agent'=>$_SERVER['HTTP_USER_AGENT'],
            'login_time'=>date('Y-m-d H:i:s'),
            'logout_time'=>''
        ));
    }
}
