<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'BISUser';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'BISUser_Name',
        'BISUser_Vorname',
        'password',
        'BISUser_email',
        'username',
    ];

    protected $hidden = ['password', 'remember_token'];
}
