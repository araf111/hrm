<?php

namespace App\Model;
use App\Model\Constituency;

use App\Model\Parliament;
use App\Model\ParliamentSession;
use App\Model\Circular;

use Illuminate\Database\Eloquent\Model;

class ParliamentTv extends Model
{

    protected $fillable = [
        'parliament_id',
        'session_id',
        'circular_id',
        'created_by',
        'url',
        'video_name',
        'status'
    ];

    public function getParlamentNo(){
        return $this->belongsTo(Parliament::class,'parliament_id','id');
    }

    public function getParliamentSession(){
        return $this->belongsTo(ParliamentSession::class,'session_id','id');
    }

    public function getCircular(){
        return $this->belongsTo(Circular::class,'circular_id','id');
    }
    
}
