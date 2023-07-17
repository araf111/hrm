<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CitizenAppointmentOtp extends Model
{
    //
    protected $fillable = [
		'mobile',
		'otp_number',
		'start_time',
		'end_time',
		'created_at',
		'updated_at'
    ];
}
