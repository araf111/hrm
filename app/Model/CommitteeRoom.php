<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommitteeRoom extends Model
{
    use SoftDeletes;

    protected $table = 'committee_rooms';
 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_bn', 
        'name_en', 
        'house_buildings_id', 
        'songshod_blocks_id', 
        'songshod_floors_id', 
        'songshod_rooms_id', 
        // 'telephone', 
        // 'pabx', 
        'status', 
        'deleted_by',
        'created_by',
        'updated_by'
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
