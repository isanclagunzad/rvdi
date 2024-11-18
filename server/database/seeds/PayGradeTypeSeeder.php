<?php

use Illuminate\Database\Seeder;
use App\Model\PayGradeType;

class PayGradeTypeSeeder extends Seeder
{
    public function run()
    {
        PayGradeType::create(['name' => 'Monthly']);
        PayGradeType::create(['name' => 'Daily']);
        PayGradeType::create(['name' => 'Hourly']);
    }
}
