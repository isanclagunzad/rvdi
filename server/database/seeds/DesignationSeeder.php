<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('designation')->truncate();
        DB::table('designation')->insert(
            [
                [ 'designation_name' => 'Director', 'created_at'=>$time, 'updated_at'=>$time ],
                [ 'designation_name' => 'Office Staff', 'created_at'=>$time, 'updated_at'=>$time ],
                [ 'designation_name' => 'Office-in-charge', 'created_at'=>$time, 'updated_at'=>$time ],
                [ 'designation_name' => 'Checker', 'created_at'=>$time, 'updated_at'=>$time ],
                [ 'designation_name' => 'Checker | Trading', 'created_at'=>$time, 'updated_at'=>$time ],
                [ 'designation_name' => 'Encoder', 'created_at'=>$time, 'updated_at'=>$time ],
                [ 'designation_name' => 'Forklift Operator', 'created_at'=>$time, 'updated_at'=>$time ],
                [ 'designation_name' => 'Picker', 'created_at'=>$time, 'updated_at'=>$time ],
                [ 'designation_name' => 'Warehouse-in-Charge', 'created_at'=>$time, 'updated_at'=>$time ],
                [ 'designation_name' => 'Warehouse-in-charge | Trading', 'created_at'=>$time, 'updated_at'=>$time ],
            ]
        );
    }
}
