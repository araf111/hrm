<?php

namespace App\Model;

use App\User;
use App\Traits\AccessModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusStage extends Model
{
    use SoftDeletes;
    use AccessModel;
    protected $guarded =['id'];

    public function lcCertificate()
    {
        return $this->belongsTo('App\Model\LCCertificate');
    }
}
