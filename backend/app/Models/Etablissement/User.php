<?php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens,HasRoles,HasFactory, Notifiable;
         
    //
    protected $guard_name = ['web', 'sanctum'];
    

    protected $fillable = [
        'name',
        'email',
        'password',
        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     // Un user EST un employé (personnel)
    public function personnel()
    {
        return $this->hasOne(Personnel::class, 'user_id');
    }
}
