<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBottomSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bottom_sections', function (Blueprint $table) {
            $table->bigIncrements( 'id' );
            
            $table->string( 'sectionName' )->nullable();

            $table->string( 'title1Bng' )->nullable();
            $table->string( 'title1Eng' )->nullable();
            $table->text( 'content1Bng' );
            $table->text( 'content1Eng' );
            
            $table->string( 'title2Bng' )->nullable();
            $table->string( 'title2Eng' )->nullable();
            $table->text( 'content2Bng' );
            $table->text( 'content2Eng' );

            $table->string( 'title3Bng' )->nullable();
            $table->string( 'title3Eng' )->nullable();
            $table->text( 'content3Bng' );
            $table->text( 'content3Eng' );

            $table->string( 'title4Bng' )->nullable();
            $table->string( 'title4Eng' )->nullable();
            $table->text( 'content4Bng' );
            $table->text( 'content4Eng' );

            $table->tinyInteger( 'status' )->default( 1 );
            $table->integer( 'created_by' );
            $table->integer( 'updated_by' )->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bottom_sections');
    }
}
