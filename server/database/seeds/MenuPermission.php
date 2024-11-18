<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

include_once 'MenuHelper.php';

class MenuPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_permission')->truncate();

        // Fetch all data from the menus table
        $menus = DB::table('menus')->get();

        // Prepare an array to insert into menu_permission
        $permissions = [];

        foreach ($menus as $menu) {
            // Create an entry for each menu item
            $permissions[] = [
                'menu_id' => $menu->id,
                'role_id' => 1,
            ];
        }

        // Insert all records into menu_permission table
        DB::table('menu_permission')->insert($permissions);
    }
}
