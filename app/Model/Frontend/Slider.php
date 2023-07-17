<?php
/**
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
 */
namespace App\Model\Frontend;

use App\Traits\AccessModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model {
    use SoftDeletes, AccessModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sliderTitleBng',
        'sliderTitleEng',
        'readMoreLink',
        'status',
        'photo',
        'logo',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];
}
