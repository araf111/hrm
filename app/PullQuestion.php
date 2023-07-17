<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PullQuestion extends Model
{
    //
    protected $with = ['options'];

    //
    public function options()
    {
        return $this->hasMany(PullMcqAnswer::class, 'q_id', 'id');
    }
}
