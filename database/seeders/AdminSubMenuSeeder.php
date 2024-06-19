<?php

namespace Database\Seeders;

use App\Models\Admin_sub_menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_sub_menu = new Admin_sub_menu();
        $admin_sub_menu->admin_menus_id = 1;
        $admin_sub_menu->name = 'Dashboard';
        $admin_sub_menu->url = '/home';
        $admin_sub_menu->icon = 'fa-tachometer-alt';
        $admin_sub_menu->save();

        $admin_sub_menu = new Admin_sub_menu();
        $admin_sub_menu->admin_menus_id = 1;
        $admin_sub_menu->name = 'Profile';
        $admin_sub_menu->url = '/profile';
        $admin_sub_menu->icon = 'fa-user';
        $admin_sub_menu->save();

        $admin_sub_menu = new Admin_sub_menu();
        $admin_sub_menu->admin_menus_id = 2;
        $admin_sub_menu->name = 'Role';
        $admin_sub_menu->url = '/admin/role';
        $admin_sub_menu->icon = 'fa-user-shield';
        $admin_sub_menu->save();

        $admin_sub_menu = new Admin_sub_menu();
        $admin_sub_menu->admin_menus_id = 2;
        $admin_sub_menu->name = 'Menu & Sub Menu';
        $admin_sub_menu->url = '/admin/menu';
        $admin_sub_menu->icon = 'fa-clipboard-list';

        $admin_sub_menu->save();
        $admin_sub_menu = new Admin_sub_menu();
        $admin_sub_menu->admin_menus_id = 2;
        $admin_sub_menu->name = 'Admin User';
        $admin_sub_menu->url = '/admin/user';
        $admin_sub_menu->icon = 'fa-users-gear';
        $admin_sub_menu->save();
    }
}
