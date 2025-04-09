<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    
    protected $table = 'user';

    protected $fillable = [
        'userid',
        'name',
        'email',
        'unit',
        'role',
        'waktu_dibuat',
        'dibuat_oleh',

    ];
    

}
