<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCutOffTable extends Migration
{
    public function up()
    {
        Schema::create('cut_off', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('start_date'); // Day of the month
            $table->integer('end_date');   // Day of the month
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cut_off');
    }
}
