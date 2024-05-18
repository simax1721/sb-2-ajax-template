<?php

namespace Database\Seeders;

use App\Models\Admin_menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_menu = new Admin_menu();
        $admin_menu->name = "Dashboard";
        $admin_menu->save();

        $admin_menu = new Admin_menu();
        $admin_menu->name = "Admin";
        $admin_menu->save();
    }
}
