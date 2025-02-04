<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = "tbl_user";
    protected $primaryKey = 'user_id';
    
    protected $fillable = [
        'role_id',
        'user_nama',
        'user_nmlengkap',
        'user_email',
        'user_password',
        'user_foto',
    ];

    protected $hidden = [
        'user_password',
    ];

    // Implement JWTSubject methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
    public function getJWTCustomClaims()
    {
        return [];
    }

    // Override default password attribute
    public function getAuthPassword()
    {
        return $this->user_password;
    }
}