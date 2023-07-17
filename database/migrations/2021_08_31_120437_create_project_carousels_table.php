<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectCarouselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_carousels', function (Blueprint $table) {
            $table->bigIncrements( 'id' );
            $table->string( 'titleBng' );
            $table->string( 'titleEng' );
            $table->text( 'contentBng' );
            $table->text( 'contentEng' );
            $table->bigInteger('category_id')->unsigned();
            $table->tinyInteger( 'status' )->default( 1 );
            $table->longText( 'photo' );
            $table->integer( 'created_by' );
            $table->integer( 'updated_by' )->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('project_categories'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_carousels');
    }
}
