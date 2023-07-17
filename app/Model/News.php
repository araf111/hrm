<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\NewsCategories;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    public function news_categories(){
        return $this->belongsTo(NewsCategories::class,'news_categories_id','id');
    }
}
