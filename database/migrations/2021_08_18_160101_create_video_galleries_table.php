<?php
/**
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoGalleriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'video_galleries', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string( 'titleBng' );
            $table->string( 'titleEng' );
            $table->string( 'youtubeLink' );
            $table->longText( 'photo' );
            $table->tinyInteger( 'status' )->default( 1 );
            $table->integer( 'created_by' );
            $table->integer( 'updated_by' )->nullable();
            $table->softDeletes();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'video_galleries' );
    }
}
