<?php

namespace App;
use App\Model\V2Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class SelectedUser extends Authenticatable implements JWTSubject
{
    //

    public function profileData() {
        return $this->hasOne( V2Profile::class, 'user_id', 'mp_id' );
    }

    /* for JWT authentication */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    public function getJWTCustomClaims() {
        return [];
    }
}

