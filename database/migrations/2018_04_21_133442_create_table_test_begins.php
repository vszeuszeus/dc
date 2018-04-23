<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTestBegins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_begins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('test_key', 255);
            $table->integer('result_count')->nullable();
            $table->integer('questions_count')->nullable();
            $table->timestamps();

            $table->foreign('test_id')->references('id')
                ->on('tests')
                ->onUpdate('cascade')
                ->onDelete('no action');

            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->unDelete('no action');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_begins', function(Blueprint $table) {
            $table->dropForeign('test_begins_test_id_foreign');
            $table->dropForeign('test_begins_user_id_foreign');
        });
        Schema::dropIfExists('test_begins');
    }
}
