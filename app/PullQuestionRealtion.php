<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PullQuestionRealtion extends Model
{
    //
    protected $with = ['questions'];

    //
    public function questions()
    {
        return $this-> belongsTo(PullQuestion::class, 'q_id', 'id');
    }
}
