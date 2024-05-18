<?php

namespace Database\Seeders;

use App\Models\Admin_prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_role = new Admin_prodi();
        $admin_role->name = "-";
        $admin_role->save();
    }
}
