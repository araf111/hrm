<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pull extends Model
{
     //
     protected $with = ['questions'];

     //
     public function questions()
     {
         return $this->hasMany(PullQuestionRealtion::class, 'p_id', 'id');
     }
}
