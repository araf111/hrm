<?php
/**
 * Author M. Atoar Rahman
 * Date: 22/08/2021
 * Time: 09:40 AM
 */
namespace App\Model\Frontend;

use App\Traits\AccessModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutSection extends Model {
    use SoftDeletes, AccessModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titleBng',
        'titleEng',
        'contentBng',
        'contentEng',
        'videoLink',
        'status',
        'videoThumbnail',
        'videoBackground',
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
