<?php

namespace Database\Seeders;

use App\Models\Admin_role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_role = new Admin_role();
        $admin_role->name = "Admin";
        $admin_role->save();

        $admin_role = new Admin_role();
        $admin_role->name = "User";
        $admin_role->save();
    }
}
