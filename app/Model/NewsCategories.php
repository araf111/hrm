<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsCategories extends Model
{
    use SoftDeletes;
    protected $guarded =[];
    protected $table = 'news_categories';
}
