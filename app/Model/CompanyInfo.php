<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'company_name_english',
        'company_name_bangla',
        'company_add_english',
        'company_add_bangla',
        'company_phone',
        'company_logo',
        'company_signature'
    ];
}
