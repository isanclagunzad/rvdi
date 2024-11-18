<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayGradeTypeIdToPayGradeTable extends Migration
{
    public function up()
    {
        Schema::table('pay_grade', function (Blueprint $table) {
            $table->unsignedInteger('pay_grade_type_id')->nullable(); // Add the column
            $table->foreign('pay_grade_type_id')->references('id')->on('pay_grade_types')->onDelete('set null'); // Foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('pay_grade', function (Blueprint $table) {
            $table->dropForeign(['pay_grade_type_id']);
            $table->dropColumn('pay_grade_type_id');
        });
    }
}
