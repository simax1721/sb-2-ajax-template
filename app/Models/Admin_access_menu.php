<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_access_menu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function admin_menu()
    {
        return $this->belongsTo(Admin_menu::class, 'admin_menus_id');
    }
    public function admin_role()
    {
        return $this->belongsTo(Admin_role::class, 'admin_roles_id');
    }
}
