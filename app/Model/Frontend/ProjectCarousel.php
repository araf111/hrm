<?php
/**
 * Author M. Atoar Rahman
 * Date: 31/08/2021
 * Time: 11:40 AM
 */

namespace App\Model\Frontend;

use App\Traits\AccessModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProjectCarousel extends Model
{
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
        'category_id',
        'photo',
        'status',
        'created_by',
        'updated_by',
    ];

    public function category() {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];
}
