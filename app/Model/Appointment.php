<?php
/**
 * Author M. Atoar Rahman
 * Date: 02/02/2021
 * Time: 09:40 AM
 */
namespace App\Model;

use App\Traits\AccessModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\CitizenAppoinment;

class Appointment extends Model
{
    use SoftDeletes;

    protected $with = ['profile', 'requested_by'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'time_from',
        'time_to',
        'type',
        'topics',
        'requested_to',
        'status',
        'created_by',
        'updated_by',
        'new_date',	
        'new_time_from',
        'new_time_to',	
        'place',
        'new_place'	,
        'rejected_reason',	
        'ministry_id',	
        'citizen_id',	
        'deleted_at',	
        'created_at',	
        'updated_at'
    ];

    public function profile() {
        return $this->belongsTo(V2Profile::class, 'requested_to');
    }

    public function requested_by() {
        return $this->belongsTo(V2Profile::class, 'created_by');
    }

    public function citizen_info() {
        return $this->belongsTo(CitizenAppoinment::class, 'citizen_id');
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
