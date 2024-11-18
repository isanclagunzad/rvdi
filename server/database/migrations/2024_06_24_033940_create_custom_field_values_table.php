<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCustomFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('custom_field_values');
        Schema::create('custom_field_values', function (Blueprint $table) {
            $table->increments('id');
            $table->text('value');

            $table->unsignedInteger('custom_field_id')
                ->nullable();
            $table->foreign('custom_field_id')
                ->references('id')
                ->on('custom_fields')
                ->onDelete('set null');
                
            $table->unsignedInteger('employee_id')
                ->nullable();
            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employee')
                ->onDelete('set null');

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
        Schema::table('custom_field_values', function (Blueprint $table) {
            $table->dropForeign('custom_field_values_employee_id_foreign');   
        });
        Schema::dropIfExists('custom_field_values');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
