<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'apellido_materno',
        'apellido_paterno',
        'edad',
        'email',
        'password',
        // 'telefono',
        // 'cargo',
    ];

    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

    // private const ROLES_HIERARCHY = [
    //     self::ROLE_SUPERADMIN => [self::ROLE_ADMIN, self::ROLE_USER],
    //     self::ROLE_ADMIN => [self::ROLE_USER],
    //     self::ROLE_USER=> []
    // ];

    private const ROLES_HIERARCHY = [
        self::ROLE_SUPERADMIN => [self::ROLE_ADMIN],
        self::ROLE_ADMIN => [self::ROLE_USER],
        self::ROLE_USER=> []
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];

    public function enviarNotificacionDePassword($token){
        
        $url = 'https://spa.test/reset-password?token='.$token;

        $this->notify(new ResetPasswordNotification($url));

    }



    public function isGranted($role){
        // return $role === $this->role || in_array($role, self::ROLES_HIERARCHY[$this->role]);
        if($role === $this->role){
            return true;
        }
        return self::isRoleInHierarchy($role,self::ROLES_HIERARCHY[$this->role]);
    }

    private static function isRoleInHierarchy($role, $role_hierarchy){
        if(in_array($role, $role_hierarchy)){
            return true;
        }

        foreach ($role_hierarchy as $role_included){
            if(self::isRoleInHierarchy($role, self::ROLES_HIERARCHY[$role_included])){
                return true;
            }
        }
        return false;
    }
}

