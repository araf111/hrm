<?php
/**
 * Author M. Atoar Rahman
 * Date: 22/08/2021
 * Time: 09:40 AM
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutSectionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'about_sections', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string( 'titleBng' );
            $table->string( 'titleEng' );
            $table->string( 'contentBng' );
            $table->string( 'contentEng' );
            $table->string( 'videoLink' );
            $table->longText( 'videoThumbnail' );
            $table->longText( 'videoBackground' );
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
        Schema::dropIfExists( 'about_sections' );
    }
}
