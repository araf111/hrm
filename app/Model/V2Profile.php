<?php

namespace App\Model;

use App\Model\Constituency;
//use App\Model\Ministry;
use App\Model\Designation;
use App\Model\Parliament;
use App\Model\PoliticalParty;
use App\Traits\AccessModel;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class V2Profile extends Model {
    use SoftDeletes;
    use AccessModel;
    protected $fillable = [
        'profileID',
        'nameEng',
        'nameBng',
        'fatherNameEng',
        'fatherNameBng',
        'motherNameEng',
        'motherNameBng',
        'spouseNameEng',
        'spouseNameBng',
        'dateOfBirth',
        'presentAddressEng',
        'presentAddressBng',
        'permanentAddressEng',
        'permanentAddressBng',
        'nidNumber',
        'birthCertificateNumber',
        'passportNumber',
        'passportIssueDate',
        'passportExpireDate',
        'gender',
        'religion',
        'bloodGroup',
        'identificationMark',
        'height',
        'personalMobile',
        'alternativeMobile',
        'email',
        'freedomFighterInfo',
        'officePhoneNumber',
        'officePhoneExtension',
        'faxNumber',
        'photo',
        'isMP',
        'professionOfMP',
        'addressOfMP',
        'user_id',
        'constituencyNumber',
        'parliamentNumber',
        'designation_id',
        'political_parties_id',
        'ministry_id',
        'spouse_nid_no',
        'office_address',
        'birth_district_id',
        'merital_status',
        'created_by',
        'updated_by',
    ];

    public function userInfo() {
        return $this->belongsTo( User::class, 'user_id', 'id' );
    }

    public function designation() {
        return $this->belongsTo( Designation::class, 'designation_id', 'id' );
    }

    public function constituency() {
        return $this->belongsTo( Constituency::class, 'constituencyNumber', 'number' );
    }

    public function parliamentInfo() {
        return $this->belongsTo( Parliament::class, 'parliament_id', 'id' );
    }
    public function partyInfo() {
        return $this->belongsTo( PoliticalParty::class, 'political_parties_id', 'id' );
    }

    /* public function ministryInfo()
    {
    return $this->belongsTo(Ministry::class,'ministry_id','id');
    } */
    public function parties() {
        return $this->belongsTo( PoliticalParty::class, 'political_parties_id', 'id' );
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
