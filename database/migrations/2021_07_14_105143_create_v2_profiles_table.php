<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateV2profilesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'v2_profiles', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'profileID' );
            $table->string( 'nameEng' );
            $table->string( 'nameBng' );
            $table->string( 'fatherNameEng' );
            $table->string( 'fatherNameBng' );
            $table->string( 'motherNameEng' );
            $table->string( 'motherNameBng' );
            $table->string( 'spouseNameEng' );
            $table->string( 'spouseNameBng' );
            $table->date( 'dateOfBirth' );
            $table->text( 'presentAddressEng' );
            $table->text( 'presentAddressBng' );
            $table->text( 'permanentAddressEng' );
            $table->text( 'permanentAddressBng' );
            $table->string( 'nidNumber' );
            $table->string( 'birthCertificateNumber' );
            $table->string( 'passportNumber' );
            $table->date( 'passportIssueDate' );
            $table->date( 'passportExpireDate' );
            $table->integer( 'gender' );
            $table->integer( 'religion' );
            $table->string( 'bloodGroup' );
            $table->string( 'identificationMark' );
            $table->string( 'height' );
            $table->string( 'personalMobile' );
            $table->string( 'alternativeMobile' );
            $table->string( 'email' );
            //$table->integer('employmentCategory')->default(0);
            $table->string( 'freedomFighterInfo' );
            $table->string( 'officePhoneNumber' );
            $table->string( 'officePhoneExtension' );
            $table->string( 'faxNumber' );
            $table->string( 'photo' );
            $table->integer( 'isMP' )->default( 1 );
            $table->string( 'professionOfMP' );
            $table->string( 'addressOfMP' );
            $table->integer( 'user_id' );
            $table->integer( 'constituency_id' );
            $table->integer( 'constituencyNumber' );
            $table->integer( 'parliamentNumber' );
            $table->integer( 'designation_id' )->default( 7 );
            $table->integer( 'political_parties_id' );
            $table->integer( 'ministry_id' );
            $table->string( 'spouse_nid_no' );
            $table->string( 'office_address' );
            $table->integer( 'birth_district_id' );
            $table->integer( 'merital_status' );
            $table->integer( 'status' );
            $table->timestamp( 'deleted_at' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'v2profiles' );
    }
}
