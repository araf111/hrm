<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Model\LoginActivity;

class LogSuccessfulLogout
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
    public function handle(Logout $event)
    {
        $existing_login = LoginActivity::where('user_id', authInfo()->id)->orderBy('id','desc')->first();
        if (!empty($existing_login)) {
            DB::table('login_activities')->where('id', $existing_login->id)->update(
                array('logout_time' => date('Y-m-d H:i:s'))
            );
        }
    }
}
