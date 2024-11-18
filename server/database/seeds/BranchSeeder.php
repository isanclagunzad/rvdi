<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('branch')->truncate();
        DB::table('branch')->insert(
            [
                ['branch_name' => 'Hilongos','created_at'=>$time,'updated_at'=>$time],
            ]
        );
    }
}
