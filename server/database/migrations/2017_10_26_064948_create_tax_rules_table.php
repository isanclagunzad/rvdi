<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_rule', function (Blueprint $table) {
            $table->increments('tax_rule_id');
            $table->double('min_income_bracket');
            $table->double('max_income_bracket')->nulllable();
            $table->double('base_amount')->nulllable();
            $table->double('tax');
            $table->string('gender', 20);
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
        Schema::dropIfExists('tax_rule');
    }
}
