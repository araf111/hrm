<?php

namespace App;

use App\Model\MpPs;
use App\Model\Profile;
use App\Model\UserRole;
use App\Model\V2Profile;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'employee_id',
        'name',
        'name_bn',
        'designation',
        'mobile_no',
        'email',
        'email_verified_at',
        'password',
        'usertype',
        'department_id',
        'profileID',
        //'user_role',
        'photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['ps_of_mp'];

    public function user_role() {
        return $this->hasMany( UserRole::class, 'user_id', 'id' );
    }

    public function psMpInfo() {
        return $this->hasOne( MpPs::class, 'ps_user_id', 'id' );
    }

    public function mpProfile() {
        return $this->hasOne( V2Profile::class, 'user_id', 'id' );
    }

    public function profileData() {
        return $this->hasOne( V2Profile::class, 'user_id', 'id' );
    }

    public function getPsOfMpAttribute() {
        if ( $this->psMpInfo ) {
            $mpUser = User::find( $this->psMpInfo->mp_user_id );
            if(session()->get('language') == 'bn'){
                return $mpUser->name_bn;
            }else{
                return $mpUser->name;
            }
        }
    }

    /* for JWT authentication */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    public function getJWTCustomClaims() {
        return [];
    }
}
