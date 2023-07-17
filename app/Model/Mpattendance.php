<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mpattendance extends Model
{
    use SoftDeletes;

    protected $table = "mpattendances";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parliament_id',
        'date', 'mp_id', 'isPresent','isMeeting', 'checkin_time','checkout_time', 'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];
}
