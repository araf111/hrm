<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RouteLog extends Model
{
    protected $fillable = [
        'user_id', 'url', 'ip_address'
    ];
}
