<?php

use Illuminate\Database\Seeder;

class TaxRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tax_rule')->truncate();
        DB::table('tax_rule')->insert([
            [
                'min_income_bracket' => 0, 
                'max_income_bracket' => 250000, 
                'base_amount' => 0,
                'tax' => 0,
                'gender' => 'Male',
            ],
            [
                'min_income_bracket' => 250001, 
                'max_income_bracket' => 400000, 
                'base_amount' => 0,
                'tax' => 15,
                'gender' => 'Male',
            ],
            [
                'min_income_bracket' => 400001, 
                'max_income_bracket' => 800000, 
                'base_amount' => 22500,
                'tax' => 20,
                'gender' => 'Male',
            ],
            [
                'min_income_bracket' => 800001, 
                'max_income_bracket' => 2000000, 
                'base_amount' => 102500,
                'tax' => 25,
                'gender' => 'Male',
            ],
            [
                'min_income_bracket' => 2000001, 
                'max_income_bracket' => 8000000, 
                'base_amount' => 402500,
                'tax' => 30,
                'gender' => 'Male',
            ],
            [
                'min_income_bracket' => 8000000, 
                'max_income_bracket' => -1, 
                'base_amount' => 2202500,
                'tax' => 35,
                'gender' => 'Male',
            ],

            [
                'min_income_bracket' => 0, 
                'max_income_bracket' => 250000, 
                'base_amount' => 0,
                'tax' => 0,
                'gender' => 'Female',
            ],
            [
                'min_income_bracket' => 250001, 
                'max_income_bracket' => 400000, 
                'base_amount' => 0,
                'tax' => 15,
                'gender' => 'Female',
            ],
            [
                'min_income_bracket' => 400001, 
                'max_income_bracket' => 800000, 
                'base_amount' => 22500,
                'tax' => 20,
                'gender' => 'Female',
            ],
            [
                'min_income_bracket' => 800001, 
                'max_income_bracket' => 2000000, 
                'base_amount' => 102500,
                'tax' => 25,
                'gender' => 'Female',
            ],
            [
                'min_income_bracket' => 2000001, 
                'max_income_bracket' => 8000000, 
                'base_amount' => 402500,
                'tax' => 30,
                'gender' => 'Female',
            ],
            [
                'min_income_bracket' => 80000001, 
                'max_income_bracket' => -1, 
                'base_amount' => 2202500,
                'tax' => 35,
                'gender' => 'Female',
            ],
        ]);
    }
}
