<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateEmployeeCustomFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('employee_custom_fields');
        Schema::create('employee_custom_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id')->nullable();
            $table->unsignedInteger('custom_field_id')->nullable();
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('employee_custom_fields');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
