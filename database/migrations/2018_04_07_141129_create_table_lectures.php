<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLectures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->longText('body');
            $table->integer('lecture_category_id')->unsigned();
            $table->timestamps();

            $table->foreign('lecture_category_id')
                ->references('id')
                ->on('lecture_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lectures', function(Blueprint $table){
            $table->dropForeign('lectures_lecture_category_id_foreign');
        });
        Schema::dropIfExists('lectures');
    }
}
