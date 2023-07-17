<?php

namespace App;

use App\Traits\AccessModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentAttachment extends Model
{
    use SoftDeletes, AccessModel;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attachment',
        'appointment_id',
        'created_by',
        'updated_by',

    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class,'appointment_id','id');
    }

    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];
}
