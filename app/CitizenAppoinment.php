<?php

namespace App;

use App\Traits\AccessModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Appointment;

class CitizenAppoinment extends Model
{
    use AccessModel;

    protected $table = "citizen_appoinments";
    
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'applicant_name',
		'father_name',
		'mother_name',
		'email',
		'nid_num',
        'mobile_num',
        'c_address',
        'p_address',
		'image',
		'ref',
		'otp_id',
		'status'
    ];

    public function otpInfo()
    {
        return $this->belongsTo(CitizenAppointmentOtp::class,'otp_id','mobile');
    }
    public function appointmentInfo()
    {
        return $this->belongsTo(Appointment::class,'id','citizen_id');
    }
}
