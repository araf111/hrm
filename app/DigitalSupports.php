<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Model\V2Profile;

class DigitalSupports extends Model
{
    //

    public function profile() {
        return $this->belongsTo(V2Profile::class, 'mp_id', 'user_id');
    }
}
