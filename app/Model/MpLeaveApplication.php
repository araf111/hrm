<?php

namespace App\Model;
use App\Model\HolidayReason;
use App\Model\Profile;
use App\Model\Constituency;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class MpLeaveApplication extends Model{

    use SoftDeletes;

    Protected $primaryKey = "id";


    protected $fillable = [
        'from_date',
        'to_date',
        'note',
        'attach_file',
        'updated_by',
        'holiday_reason_id',
        'application_for',
        'status',
        'remarks',
        'decide_by',
        'decide_at',
        'submission_date',

    ];


    public function holiday_reasons(){
        return $this->belongsTo(HolidayReason::class,'holiday_reason_id','id');
    }

    public function profileInfo(){
        return $this->belongsTo(Profile::class,'application_for','user_id')
            ->join('constituencies', 'constituencies.id', '=', 'profiles.constituency_id');
    }


}
