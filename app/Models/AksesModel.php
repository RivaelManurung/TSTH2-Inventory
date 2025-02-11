<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role; // Import model Role dari Spatie

class AksesModel extends Model
{
    protected $table = "tbl_akses";
    protected $primaryKey = 'akses_id';
    protected $fillable = [
        'menu_id',
        'submenu_id',
        'othermenu_id',
        'role_id',
        'akses_type'
    ];

    // Menghubungkan AksesModel dengan Role menggunakan 'role_id'
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id'); // Menggunakan 'id' yang merupakan primary key di tabel roles
    }
    public function menu()
    {
        return $this->belongsTo(MenuModel::class, 'menu_id', 'menu_id');
    }
    public function submenu()
    {
        return $this->belongsTo(SubmenuModel::class, 'submenu_id', 'submenu_id');
    }
}
