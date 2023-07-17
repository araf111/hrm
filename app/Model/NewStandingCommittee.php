<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewStandingCommittee extends Model
{
    use SoftDeletes;
    Protected $primaryKey = "id";
}
