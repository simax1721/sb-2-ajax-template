<?php

namespace Database\Seeders;

use App\Models\Admin_access_menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminAccessMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_menu = new Admin_access_menu();
        $admin_menu->admin_roles_id = 1;
        $admin_menu->admin_menus_id = 1;
        $admin_menu->save();

        $admin_menu = new Admin_access_menu();
        $admin_menu->admin_roles_id = 1;
        $admin_menu->admin_menus_id = 2;
        $admin_menu->save();

        $admin_menu = new Admin_access_menu();
        $admin_menu->admin_roles_id = 2;
        $admin_menu->admin_menus_id = 1;
        $admin_menu->save();
    }
}
