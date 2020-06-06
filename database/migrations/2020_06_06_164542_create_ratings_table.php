<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('file_id');
            $table->tinyInteger('rating', false, true);
            $table->timestamps();

            $table
                ->foreign('user_id')
                ->references(['id'])
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table
                ->foreign('file_id')
                ->references('id')
                ->on('files')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating');
    }
}
