<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKasusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fact1');
            $table->integer('fact1w')->default(1);
            $table->string('fact2');
            $table->integer('fact2w')->default(1);
            $table->string('fact3');
            $table->integer('fact3w')->default(1);
            $table->string('fact4');
            $table->integer('fact4w')->default(1);
            $table->string('solving');
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
        Schema::dropIfExists('kasus');
    }
}
