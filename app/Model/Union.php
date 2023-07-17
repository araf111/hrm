<?php

namespace App\Model;

use App\Traits\AccessModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Union extends Model
{
    use SoftDeletes, AccessModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'bn_name', 
        'lat', 
        'lon',  
        'status', 
        'upazila_id', 
        'district_id', 
        'division_id', 
        'created_by', 
        'updated_by'
    ];



    // Foreign key relation with District and Division table.
    public function upazila() {
        return $this->belongsTo(Upazila::class, 'upazila_id');
    }
    public function district() {
        return $this->belongsTo(District::class, 'district_id');
    }
	public function division() {
        return $this->belongsTo(Division::class, 'division_id');
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
