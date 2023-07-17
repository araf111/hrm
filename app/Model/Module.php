<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','name_bn','status','color'];

    public function menu() {
        return $this->hasMany( Menu::class, 'module_id', 'id' )->where('parent',0);
    }
}
