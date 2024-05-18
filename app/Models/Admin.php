<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function admin_prodi()
    {
        return $this->belongsTo(Admin_prodi::class, 'admin_prodis_id');
    }

    public function admin_role()
    {
        return $this->belongsTo(Admin_role::class, 'admin_roles_id');
    }
}
