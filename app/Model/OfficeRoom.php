<?php

namespace App\Model;

use App\Model\HostelBlock;
use App\Model\HostelBuilding;
use App\Model\HostelFloor;
use App\Model\OfficeRoomType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class OfficeRoom extends Model
{
    
    use SoftDeletes;

    protected $table = "office_rooms";


    public function hostel_building()
    {
        return $this->belongsTo(HostelBuilding::class, 'hostel_building_id', 'id');
    }

    public function office_room_type()
    {
        return $this->belongsTo(OfficeRoomType::class, 'office_room_type_id', 'id');
    }

    public function hostel_block()
    {
        return $this->belongsTo(HostelBlock::class, 'hostel_block_id', 'id');
    }
    public function hostel_floor()
    {
        return $this->belongsTo(HostelFloor::class,'hostel_floor_id');
    }

    protected $hidden = [
        'deleted_at'
    ];


}
