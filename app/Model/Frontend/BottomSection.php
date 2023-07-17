<?php
/**
 * Author M. Atoar Rahman
 * Date: 31/08/2021
 * Time: 09:40 AM
 */
namespace App\Model\Frontend;

use App\Traits\AccessModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BottomSection extends Model
{
    use SoftDeletes, AccessModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sectionName',

        'title1Bng',
        'title1Eng',
        'content1Bng',
        'content1Eng',

        'title2Bng',
        'title2Eng',
        'content2Bng',
        'content2Eng',

        'title3Bng',
        'title3Eng',
        'content3Bng',
        'content3Eng',

        'title4Bng',
        'title4Eng',
        'content4Bng',
        'content4Eng',

        'status',
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
