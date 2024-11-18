<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CutOffSeeder extends Seeder
{
    public function run()
    {
        DB::table('cut_off')->insert([
            [
                'name' => 'First Half',
                'start_date' => 1,  // 1st day of the month
                'end_date' => 15    // 15th day of the month
            ],
            [
                'name' => 'Second Half',
                'start_date' => 16, // 16th day of the month
                'end_date' => 31    // 31st day of the month
            ]
        ]);
    }
}

