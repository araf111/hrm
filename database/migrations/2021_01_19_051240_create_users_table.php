<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'users', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->bigInteger( 'employee_id' )->nullable();
            $table->string( 'name' )->nullable();
            $table->string( 'name_bn' )->nullable();
            $table->string( 'designation' )->nullable();
            $table->string( 'mobile_no' )->nullable();
            $table->string( 'email' )->unique();
            $table->timestamp( 'email_verified_at' )->nullable();
            // $table->string( 'mobile' )->unique();
            $table->string( 'password' );
            $table->enum( 'usertype', ['staff', 'speaker', 'mp', 'ps'] )->nullable();
            $table->bigInteger( 'department_id' )->unsigned()->nullable();
            $table->string( 'profileID' )->nullable();
            // $table->bigInteger( 'user_role' )->unsigned()->nullable();
            $table->string( 'photo' )->nullable();
            $table->dateTime( 'deleted_at' )->nullable();
            $table->foreign( 'department_id' )->references( 'id' )->on( 'departments' );
            // $table->foreign( 'user_role' )->references( 'id' )->on( 'user_roles' );
            $table->rememberToken();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'users' );
    }
}
