<?php

use Illuminate\Database\Seeder;


class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->truncate();
        DB::table('modules')->insert(
            [
                ['id' => \App\Constants\ModuleConstants::ADMINISTRATION, 'name' => 'Administration','icon_class' => 'mdi mdi-contacts'],
                ['id' => \App\Constants\ModuleConstants::EMPLOYEES, 'name' => 'Employees','icon_class' => 'mdi mdi-account-multiple-plus'],
                ['id' => \App\Constants\ModuleConstants::LEAVES, 'name' => 'Leaves','icon_class' => 'mdi mdi-format-line-weight'],
                ['id' => \App\Constants\ModuleConstants::ATTENDANCE, 'name' => 'Attendance','icon_class' => 'mdi mdi-clock-fast'],
                ['id' => \App\Constants\ModuleConstants::PAYROLL, 'name' => 'Payroll','icon_class' => 'mdi mdi-cash'],
                ['id' => \App\Constants\ModuleConstants::PERFORMANCE, 'name' => 'Performance','icon_class' => 'mdi mdi-calculator'],
                ['id' => \App\Constants\ModuleConstants::RECRUITMENT, 'name' => 'Recruitment','icon_class' => 'mdi mdi-newspaper'],
                ['id' => \App\Constants\ModuleConstants::TRAINING, 'name' => 'Training','icon_class' => 'mdi mdi-web'],
                ['id' => \App\Constants\ModuleConstants::AWARD, 'name' => 'Award','icon_class' => 'mdi mdi-trophy-variant'],
                ['id' => \App\Constants\ModuleConstants::NOTICE_BOARD, 'name' => 'Notice Board','icon_class' => 'mdi mdi-flag'],
                ['id' => \App\Constants\ModuleConstants::SETTINGS, 'name' => 'Settings','icon_class' => 'mdi mdi-settings'],
            ]
        );
    }
}
