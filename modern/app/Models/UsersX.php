<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersX extends Model
{
    protected $table = 'usersX';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;
}
