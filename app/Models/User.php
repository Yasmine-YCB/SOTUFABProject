<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    use HasFactory;
    protected $table='users';
    public  $timestamps = false;
    protected $connection = 'sqlsrv1';
    protected $fillable = [
        'id',
        'PER_id',
        'CLI_id',
        'authorities_id',
        'first_Name',
        'last_Name',
        'username',
        'password',
        'gsm',
        'EMAIL',
        'SMS',
        'enabled',
        'created_at',
        'last_password_reset_date',
        'updated_at' 

           
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
