<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function child(){
    	return $this->hasMany(Menu::class,'parent','id');
    }

    public function permission(){
    	return $this->hasMany(MenuPermission::class);
    }

    public function module(){
    	return $this->belongsTo(Module::class);
    }
}
