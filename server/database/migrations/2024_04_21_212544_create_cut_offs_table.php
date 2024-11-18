<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCutOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cut_offs', function (Blueprint $table) {
            $table->increments('cuttoff_id');
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            // WIP foreign key soon
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
        Schema::dropIfExists('cut_offs');
    }
}
