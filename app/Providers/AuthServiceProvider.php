<?php

namespace App\Providers;

use App\Model\TravelAllowanceBill;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // gates

        // restrict to only own travel bills view
        Gate::define('can-touch-travel-bill', function (User $user, TravelAllowanceBill $travelAllowanceBill) {
            return in_array($user->id, [$travelAllowanceBill->for, $travelAllowanceBill->by], true);
        });
    }
}
